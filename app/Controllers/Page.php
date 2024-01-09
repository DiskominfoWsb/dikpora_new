<?php

namespace App\Controllers;

use function PHPUnit\Framework\assertDirectoryDoesNotExist;

class Page extends BaseController
{
    protected $db;
    protected $prefix;
    protected $data = [];

    public function __construct()
    {
        $this->db       = \Config\Database::connect();
        $this->prefix   = $this->db->getPrefix();
        helper([
            'date', 'my_date', 'text', 'security', 'page',
            'option','menu','category','service', 'comment',
            'counter',
        ]);

        $this->data['controller'] = 'page';

        //nav menu badge
        $this->data['unapproveService'] = unapproveServiceCount($this->db);
        $this->data['unapproveComment'] = unapproveCommentCount($this->db);

        //sidebar categories
        $this->data['categoriesList'] = getCategories($this->db);
        //sidebar popular tag
        $this->data['popularTags'] = getTags($this->db);

        //new menu tree
        $this->data['menuNewTree1']  = getMenuNewTree('text-light', $this->db);
        //$this->data['menuNewTree2']  = getMenuNewTree('text-light', $this->db);

    }

    public function index()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //check search form
        $status = $this->request->getGet('status');
        $status = ($status === '0') ? '0' : '1';
        $keywords = trim($this->request->getGet('keywords'));

        //retrieve pages data
        $builder = $this->db->table('page');
        $builder->selectCount('ID');
        $builder->where('status', $status);
        if($keywords)
        {
            $builder->groupStart()
                ->like('page.title', $keywords)
                ->orLike('page.content', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('page.date_created', 'DESC');
        $rows = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($this->request->getGet('page') ?? 1);
        $perPage    = 25;
        $total      = $rows->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page-1)*$perPage;

        //retrieve with pagination
        $builder->resetQuery();
        $builder->select('page.ID,page.ID_page,page.title,page.slug,page.date_created,page.hits,page.place_order,user.username');
        $builder->join('user', 'user.ID = page.ID_user');
        $builder->where('status', $status);
        if($keywords)
        {
            $builder->groupStart()
                ->like('page.title', $keywords)
                ->orLike('page.content', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('page.date_created', 'DESC');
        $builder->limit($perPage, $this->data['pagerStart']);
        $result = $builder->get()->getResult();
        $this->data['pages'] = $result;

        //counting comments
        $pageIDs = [];
        foreach($result as $p)
        {
            $pageIDs[] = $p->ID;
        }
        //query count from table
        $builder->resetQuery();
        $builder = $this->db->table('comment');
        $builder->select("{$this->prefix}comment.ID_post_page AS ID_page, COUNT({$this->prefix}comment.ID_post_page) AS counts", false);
        $builder->where('type', 'page');
        $builder->groupBy('ID_post_page');
        $result = $builder->get()->getResult();
        $comment = [];
        foreach($result as $r)
        {
            $comment[$r->ID_page] = $r->counts;
        }
        $this->data['commentsCount'] = $comment;

        //make a parent array
        $parent = [];
        $builder->resetQuery();
        $builder = $this->db->table('page');
        $builder->select('ID,title');
        $result = $builder->get()->getResult();
        foreach($result as $res)
        {
            $parent[$res->ID] = $res->title;
        }
        $this->data['parents'] = $parent;

        echo view('admin-header', $this->data);
        echo view('page');
        echo view('admin-footer');
    }

    protected function slug($text)
    {
        $slug = url_title(convert_accented_characters($text), '-', true);
        //check existing slug
        $builder = $this->db->table('page');
        $builder->select('slug');
        $builder->where('slug', $slug);
        $result = $builder->get()->getRow();
        if($result) $slug = increment_string($slug, '_');
        return $slug;
    }

    public function new()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //retrieve page data
        $builder = $this->db->table('page');
        $builder->select('ID,ID_page,title');
        $builder->orderBy('ID_page DESC, place_order ASC, title ASC');
        $result = $builder->get()->getResultArray();
        $this->data['pages'] = $result;

        //retrieve user data
        $builder->resetQuery();
        $builder = $this->db->table('user');
        $builder->orderBy('username');
        $result = $builder->get()->getResult();
        $this->data['users'] = $result;

        echo view('admin-header', $this->data);
        echo view('page-new');
        echo view('admin-footer');
    }

    public function addNew()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //get post form data
        $title          = $this->request->getPost('title');
        $slug           = $this->slug($title);
        $content        = $this->request->getPost('content');
        $parent         = $this->request->getPost('parent');
        $tags           = $this->request->getPost('tags');
        $author         = $this->request->getPost('author');
        $date_created   = $this->request->getPost('date').date(' H:i:s', now());
        $last_modified  = $date_created;
        $status         = ($this->request->getPost('publish-now')) ? '1' : '0';
        $image          = $this->request->getFile('image');
        $place_order    = $this->request->getPost('place-order');
        $css_id         = $this->request->getPost('css-id');
        $css_class      = $this->request->getPost('css-class');

        //upload file image
        $name           = '';
        $onlyName       = '';
        $onlyExtension  = '';
        $path = ROOTPATH.'public/upload/img/';
        if($image->isValid() && !$image->hasMoved())
        {
            $name = $image->getRandomName();
            $image->move($path, $name);

            $namE           = explode('.', $name);
            $onlyName       = $namE[0];
            $onlyExtension  = $namE[1];

            //resizing image
            $thumbnail = \Config\Services::image();
            $thumbnail->withFile($path.$name)
                ->resize(350, 350, true, 'width')
                ->save($path.$onlyName.'_thumb.'.$onlyExtension);

            //set image url
            $image = base_url('upload/img/'.$onlyName.'_thumb.'.$onlyExtension);
        }
        else
        {
            $image = '';
        }

        //table data
        $data = [
            'ID'             => null,
            'ID_page'        => $parent,
            'ID_user'        => $author,
            'title'          => trim($title),
            'slug'           => $slug,
            'content'        => $content,
            'tags'           => $tags,
            'featured_image' => $image,
            'date_created'   => $date_created,
            'last_modified'  => $last_modified,
            'hits'           => 0,
            'place_order'    => $place_order,
            'css_id'         => $css_id,
            'css_class'      => $css_class,
            'status'         => $status,
        ];

        //send to database
        $builder = $this->db->table('page');
        $builder->insert($data);

        //check if inserted
        $alert = [];
        if($this->db->affectedRows() > 0)
        {
            $alert = [
                'type'      => 'success',
                'message'   => 'Berhasil menyimpan halaman baru.'
            ];
        }
        else
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal menyimpan halaman baru!'
            ];
        }

        session()->setFlashdata('alert', $alert);
        return redirect()->to('page');
    }

    public function edit()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        $id = $this->request->getGet('id');
        //retrieve post data
        $builder = $this->db->table('page');
        $builder->where('ID', $id);
        $result = $builder->get()->getRow();
        if(!$result) return redirect()->to('page');
        $this->data['page'] = $result;

        //retrieve all pages
        $builder->resetQuery();
        $builder->select('ID,ID_page,title');
        $builder->orderBy('ID_page DESC, place_order ASC, title ASC');
        $result = $builder->get()->getResultArray();
        $this->data['pages'] = $result;

        //retrieve user data
        $builder->resetQuery();
        $builder = $this->db->table('user');
        $builder->orderBy('username');
        $result = $builder->get()->getResult();
        $this->data['users'] = $result;

        echo view('admin-header', $this->data);
        echo view('page-edit');
        echo view('admin-footer');
    }

    public function update()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //get post form data
        $id             = $this->request->getPost('id');
        $title          = $this->request->getPost('title');
        $slug           = $this->slug($title);
        $content        = $this->request->getPost('content');
        $parent         = $this->request->getPost('parent');
        $tags           = $this->request->getPost('tags');
        $author         = $this->request->getPost('author');
        $date_created   = $this->request->getPost('date').date(' H:i:s', now());
        $last_modified  = date('Y-m-d H:i:s', now());
        $place_order    = $this->request->getPost('place-order');
        $css_id         = $this->request->getPost('css-id');
        $css_class      = $this->request->getPost('css-class');
        $status         = ($this->request->getPost('publish-now')) ? '1' : '0';
        $image_old      = $this->request->getPost('image-old');
        $image          = $this->request->getFile('image');

        //upload file image
        $name           = '';
        $onlyName       = '';
        $onlyExtension  = '';
        $path = ROOTPATH.'public/upload/img/';
        if($image->isValid() && !$image->hasMoved())
        {
            $name = $image->getRandomName();
            $image->move($path, $name);

            $namE           = explode('.', $name);
            $onlyName       = $namE[0];
            $onlyExtension  = $namE[1];

            //resizing image
            $thumbnail = \Config\Services::image();
            $thumbnail->withFile($path.$name)
                ->resize(350, 350, true, 'width')
                ->save($path.$onlyName.'_thumb.'.$onlyExtension);

            //set image url
            $image = base_url('upload/img/'.$onlyName.'_thumb.'.$onlyExtension);
        }
        else
        {
            $image = $image_old;
        }

        //table data
        $data = [
            'ID_page'        => $parent,
            'ID_user'        => $author,
            'title'          => trim($title),
            //'slug'           => $slug,
            'content'        => $content,
            'tags'           => $tags,
            'featured_image' => $image,
            'date_created'   => $date_created,
            'last_modified'  => $last_modified,
            'place_order'    => $place_order,
            'css_id'         => $css_id,
            'css_class'      => $css_class,
            'status'         => $status,
        ];

        //send to database
        $builder = $this->db->table('page');
        $builder->where('ID', $id);
        $builder->update($data);

        //check if inserted
        $alert = [];
        if($this->db->affectedRows() > 0)
        {
            //memperbarui nav_menu
            if($parent)
            {
                $optionNavMenu = getOption('nav_menu', $this->db);
                $optionNavMenu = unserialize($optionNavMenu);
                for($i=0;$i<count($optionNavMenu);$i++)
                {
                    if($optionNavMenu[$i]['menu_ID'] == $parent)
                    {
                        $childs = $optionNavMenu[$i]['menu_child'];
                        $exists = false;
                        for($j=0;$j<count($childs);$j++)
                        {
                            if($childs[$j]['menu_ID'] == $id) $exists = true;
                        }
                        if(!$exists)
                        {
                            array_push($optionNavMenu[$i]['menu_child'], [
                                'menu_ID'    => $id,
                                'menu_child' => [],
                            ]);
                        }
                    }
                    else
                    {
                        $childs = $optionNavMenu[$i]['menu_child'];
                        for($j=0;$j<count($childs);$j++)
                        {
                            if($childs[$j]['menu_ID'] == $parent)
                            {
                                $childz = $childs[$j]['menu_child'];
                                $existz = false;
                                for($k=0;$k<count($childz);$k++)
                                {
                                    if($childz[$k]['menu_ID'] == $id) $existz = true;
                                }
                                if(!$existz)
                                {
                                    array_push($optionNavMenu[$i]['menu_child'][$j]['menu_child'], [
                                        'menu_ID'    => $id,
                                        'menu_child' => [],
                                    ]);
                                }
                            }
                            else
                            {
                                $childz = $childs[$j]['menu_child'];
                                for($k=0; $k<count($childz);$k++)
                                {
                                    if($childz[$k]['menu_ID'] == $parent)
                                    {
                                        $childx = $childz[$k]['menu_child'];
                                        $existx = false;
                                        for($l=0;$l<count($childx);$l++)
                                        {
                                            if($childx[$l]['menu_ID'] == $id) $existx = true;
                                        }
                                        if(!$existx)
                                        {
                                            array_push($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'], [
                                                'menu_ID'    => $id,
                                                'menu_child' => [],
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                updateOption('nav_menu', serialize($optionNavMenu), $this->db);
            }
            $alert = [
                'type'      => 'success',
                'message'   => 'Berhasil memperbaharui halaman.'
            ];
        }
        else
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal memperbaharui halaman!'
            ];
        }

        session()->setFlashdata('alert', $alert);
        return redirect()->to('page');
    }

    public function editStatus()
    {
        $id     = $this->request->getGet('id');
        $status = $this->request->getGet('status');

        $builder = $this->db->table('page');
        $builder->set('status', $status);
        $builder->where('ID', $id);
        $builder->update();

        $stat = ($status === '0') ? 'menghapus' : 'merestore';
        if($this->db->affectedRows() > 0)
        {
            //memperbarui nav_menu
            $optionNavMenu = getOption('nav_menu', $this->db);
            $optionNavMenu = unserialize($optionNavMenu);
            $builder->resetQuery();
            $builder->select('ID_page');
            $builder->where('ID', $id);
            $parent = $builder->get()->getRow()->ID_page;
            for($i=0;$i<count($optionNavMenu);$i++)
            {
                if($status === '0')
                {
                    $child = $optionNavMenu[$i]['menu_child'];
                    for($j=0;$j<count($child);$j++)
                    {
                        if($child[$j]['menu_ID'] == $id)
                        {
                            unset($optionNavMenu[$i]['menu_child'][$j]);
                            $optionNavMenu[$i]['menu_child'] = array_values($optionNavMenu[$i]['menu_child']);
                        }
                        else
                        {
                            $childs = $child[$j]['menu_child'];
                            for($k=0;$k<count($childs);$k++)
                            {
                                if($childs[$k]['menu_ID'] == $id)
                                {
                                    unset($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]);
                                    $optionNavMenu[$i]['menu_child'][$j]['menu_child'] = array_values($optionNavMenu[$i]['menu_child'][$j]['menu_child']);
                                }
                                else
                                {
                                    $childz = $childs[$k]['menu_child'];
                                    for($l=0;$l<count($childz);$l++)
                                    {
                                        if($childz[$l]['menu_ID'] == $id)
                                        {
                                            unset($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'][$l]);
                                            $optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'] = array_values($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child']);
                                        }
                                        else
                                        {
                                            $child0 = $childz[$l]['menu_child'];
                                            for($m=0;$m<count($child0);$m++)
                                            {
                                                if($child0[$m]['menu_ID'] == $id) unset($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'][$l]['menu_child'][$m]);
                                                $optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'][$l]['menu_child'] = array_values($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'][$l]['menu_child']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //reindex after unset
                    $optionNavMenu[$i]['menu_child'] = array_values($optionNavMenu[$i]['menu_child']);
                }
                else
                {
                    if($optionNavMenu[$i]['menu_ID'] == $parent)
                    {
                        $childs = $optionNavMenu[$i]['menu_child'];
                        $exists = false;
                        for($j=0;$j<count($childs);$j++)
                        {
                            if($childs[$j]['menu_ID'] == $id) $exists = true;
                        }
                        if(!$exists)
                        {
                            array_push($optionNavMenu[$i]['menu_child'], [
                                'menu_ID'    => $id,
                                'menu_child' => [],
                            ]);
                        }
                    }
                    else
                    {
                        $child = $optionNavMenu[$i]['menu_child'];
                        for($j=0;$j<count($child);$j++)
                        {
                            if($child[$j]['menu_ID'] == $parent)
                            {
                                $childs = $child[$j]['menu_child'];
                                $exist = false;
                                for($k=0;$k<count($childs);$k++)
                                {
                                    if($childs[$k]['menu_ID'] == $id) $exist = true;
                                }
                                if(!$exist)
                                {
                                    array_push($optionNavMenu[$i]['menu_child'][$j]['menu_child'], [
                                        'menu_ID'    => $id,
                                        'menu_child' => [],
                                    ]);
                                }
                            }
                            else
                            {
                                $childs = $child[$j]['menu_child'];
                                for($k=0;$k<count($childs);$k++)
                                {
                                    if($childs[$k]['menu_ID'] == $parent)
                                    {
                                        $childz = $childs[$k]['menu_child'];
                                        $exists = false;
                                        for($l=0;$l<count($childz);$l++)
                                        {
                                            if($childz[$l]['menu_ID'] == $id) $exists = true;
                                        }
                                        if(!$exists)
                                        {
                                            array_push($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'], [
                                                'menu_ID'    => $id,
                                                'menu_child' => [],
                                            ]);
                                        }
                                    }
                                    else
                                    {
                                        $childz = $childs[$k]['menu_child'];
                                        for($l=0;$l<count($childz);$l++)
                                        {
                                            if($childz[$l]['menu_ID'] == $parent)
                                            {
                                                $child0 = $childz[$l]['menu_child'];
                                                $existz = false;
                                                for($m=0;$m<count($child0);$m++)
                                                {
                                                    if($child0[$m]['menu_ID'] == $id) $existz = true;
                                                }
                                                if(!$existz)
                                                {
                                                    array_push($optionNavMenu[$i]['menu_child'][$j]['menu_child'][$k]['menu_child'][$l]['menu_child'], [
                                                        'menu_ID'    => $id,
                                                        'menu_child' => [],
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            updateOption('nav_menu', serialize($optionNavMenu), $this->db);

            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => "Berhasil {$stat} halaman yang dipilih.",
            ]);
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => "Gagal {$stat} halaman yang dipilih!",
            ]);
        }
        return redirect()->back();
    }

    public function article($slug)
    {
        /**
        registerPageNavMenu([
            'option_name'   => 'nav_menu',
            'option_value'  => serialize([
                [
                    'menu_ID'    => 2,
                    'menu_child' => [
                        [
                            'menu_ID'    => 3,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 4,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 5,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 6,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 7,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 8,
                            'menu_child' => [],
                        ],
                    ],
                ],
                [
                    'menu_ID'    => 9,
                    'menu_child' => [
                        [
                            'menu_ID'    => 10,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 11,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 12,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 13,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 14,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 15,
                            'menu_child' => [],
                        ],
                    ],
                ],
                [
                    'menu_ID'    => 16,
                    'menu_child' => [
                        [
                            'menu_ID'    => 17,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 18,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 19,
                            'menu_child' => [],
                        ],
                        [
                            'menu_ID'    => 20,
                            'menu_child' => [],
                        ],
                    ],
                ],
            ]),
        ], $this->db);
        */

        $news_ID_category = 6;
        //retrieve page data
        $builder = $this->db->table('page');
        $builder->where('slug', $slug);
        $result = $builder->get()->getRow();
        //redirect to search if not found
        if(!$result) return redirect()->to('https://www.google.com/search?q='.urlencode(str_replace('-',' ', $slug.' dikpora wonosobo')));
        $this->data['article'] = $result;

        //comment form
        $this->data['attachComment'] = 1;
        //get comments message
        $myComment = getPageCommentArray($result->ID, $this->db, 'ASC');
        $myComment = commentTreeRow($myComment);
        $myComment = json_decode(json_encode($myComment));
        $this->data['comments'] = $myComment;

        //add hits counter to this page
        $builder->resetQuery();
        $builder->where('slug', $slug);
        $builder->set('hits', 'hits+1', false);
        $builder->update();

        //3 new article
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        //visitor adn views count
        doVisitation($this->db);
        doView($this->db);

        //option footer
        $this->data['counter'] = [
            'visit' => getOption('counter_visit', $this->db),
            'view'  => getOption('counter_view', $this->db),
        ];
        $this->data['social'] = [
            'youtube'   => getOption('social_youtube', $this->db),
            'instagram' => getOption('social_instagram', $this->db),
            'facebook'  => getOption('social_facebook', $this->db),
            'twitter'   => getOption('social_twitter', $this->db),
        ];
        $this->data['footerLink']       = unserialize(getOption('footer_link', $this->db));
        $this->data['footerContact']    = [
            'footer_address'    => getOption('contact_address', $this->db),
            'footer_phone'      => getOption('contact_phone', $this->db),
            'footer_email'      => getOption('contact_email', $this->db),
            'footer_website'    => getOption('contact_website', $this->db),
        ];

        echo view('header', $this->data);
        echo view('halaman');
        echo view('footer');
    }

    public function dip()
    {
        $ID_category = trim($this->request->getGet('category'));
        $keywords    = trim($this->request->getGet('keywords'));

        //news category
        $newsCats = [
            [
                'ID'    => 2,
                'name'  => 'Informasi Setiap Saat',
            ],
            [
                'ID'    => 3,
                'name'  => 'Informasi Serta Merta',
            ],
            [
                'ID'    => 4,
                'name'  => 'Informasi Berkala',
            ],
            [
                'ID'    => 5,
                'name'  => 'Informasi Dikecualikan',
            ],
        ];
        $this->data['newsCats'] = $newsCats;

        $newsCats = ($ID_category) ? [['ID' => $ID_category]] : $newsCats;

        $IDs = [];
        //retrieve data from posts
        $builder = $this->db->table('post');
        $builder->select('ID,ID_category');
        $builder->where('status', '1');
        $result = $builder->get()->getResult();
        foreach($result as $res)
        {
            $IDcats = explode(',', $res->ID_category);
            //check one by one of newscats id
            for($i=0; $i<count($newsCats); $i++)
            {
                if(in_array($newsCats[$i]['ID'], $IDcats))
                {
                    $IDs[] = $res->ID;
                    break;
                }
            }
        }

        if(!$IDs) $IDs = [2147483647];

        $builder->resetQuery();
        $builder->selectCount('ID');
        $builder->where('status', '1');
        $builder->whereIn('ID', $IDs);
        if($keywords) $builder->like('title', $keywords);
        $result = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($this->request->getGet('page') ?? 1);
        $perPage    = 25;
        $total      = $result->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page-1)*$perPage;

        //paged post
        $builder->resetQuery();
        $builder->select('title,slug,last_modified');
        $builder->where('status', '1');
        $builder->whereIn('ID', $IDs);
        if($keywords) $builder->like('title', $keywords);
        $builder->orderBy('last_modified', 'DESC');
        $builder->limit($perPage, $this->data['pagerStart']);
        $result = $builder->get()->getResult();
        $this->data['posts'] = $result;

        //3 new article
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        //acting like article attr
        $obj = new \stdClass();
        $obj->title     = 'Daftar Informasi Publik';
        $obj->slugs     = 'dip';
        $obj->content   = 'Daftar Informasi Publik';
        $obj->tags      = 'dip,informasi';
        $this->data['article'] = $obj;

        //visitor adn views count
        doVisitation($this->db);
        doView($this->db);

        //option footer
        $this->data['counter'] = [
            'visit' => getOption('counter_visit', $this->db),
            'view'  => getOption('counter_view', $this->db),
        ];
        $this->data['social'] = [
            'youtube'   => getOption('social_youtube', $this->db),
            'instagram' => getOption('social_instagram', $this->db),
            'facebook'  => getOption('social_facebook', $this->db),
            'twitter'   => getOption('social_twitter', $this->db),
        ];
        $this->data['footerLink']       = unserialize(getOption('footer_link', $this->db));
        $this->data['footerContact']    = [
            'footer_address'    => getOption('contact_address', $this->db),
            'footer_phone'      => getOption('contact_phone', $this->db),
            'footer_email'      => getOption('contact_email', $this->db),
            'footer_website'    => getOption('contact_website', $this->db),
        ];

        //view
        echo view('header', $this->data);
        echo view('dip');
        echo view('footer');

    }

}