<?php

namespace App\Controllers;

use Google\Cloud\Storage\StorageClient;

class Post extends BaseController
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
            'option', 'menu', 'category', 'service', 'comment',
            'counter',
        ]);

        $this->data['controller'] = 'post';

        //nav menu badge
        $this->data['unapproveService'] = unapproveServiceCount($this->db);
        $this->data['unapproveComment'] = unapproveCommentCount($this->db);

        //sidebar categories
        $this->data['categoriesList'] = getCategories($this->db);
        //sidebar popular tag
        $this->data['popularTags'] = getTags($this->db);

        //comment form
        $this->data['attachComment'] = 1;

        //new menu tree
        $this->data['menuNewTree1']  = getMenuNewTree('text-light', $this->db);
        //$this->data['menuNewTree2']  = getMenuNewTree('text-light', $this->db);

    }

    public function index()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //check search form
        $status = $this->request->getGet('status');
        $status = ($status === '0') ? '0' : '1';
        $keywords   = trim($this->request->getGet('keywords'));

        //retrieve posts data
        $builder = $this->db->table('post');
        $builder->selectCount('ID');
        $builder->where('status', $status);
        if ($keywords) {
            $builder->groupStart()
                ->like('post.title', $keywords)
                ->orLike('post.content', $keywords)
                ->groupEnd();
        }
        $rows = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($this->request->getGet('page') ?? 1);
        $perPage    = 25;
        $total      = $rows->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page - 1) * $perPage;

        //retrieve with pagination
        $builder->resetQuery();
        $builder->select('post.ID,post.title,post.slug,post.date_created,post.hits,user.username');
        $builder->join('user', 'user.ID = post.ID_user');
        $builder->where('post.status', $status);
        if ($keywords) {
            $builder->groupStart()
                ->like('post.title', $keywords)
                ->orLike('post.content', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('post.date_created', 'DESC');
        $builder->limit($perPage, $this->data['pagerStart']);
        $result = $builder->get()->getResult();
        $this->data['posts'] = $result;

        //counting comments
        $postIDs = [];
        foreach ($result as $p) {
            $postIDs[] = $p->ID;
        }
        //query count from table
        $builder->resetQuery();
        $builder = $this->db->table('comment');
        $builder->select("{$this->prefix}comment.ID_post_page AS ID_post, COUNT({$this->prefix}comment.ID_post_page) AS counts", false);
        $builder->where('type', 'post');
        $builder->groupBy('ID_post_page');
        $result = $builder->get()->getResult();
        $comment = [];
        foreach ($result as $r) {
            $comment[$r->ID_post] = $r->counts;
        }
        $this->data['commentsCount'] = $comment;

        echo view('admin-header', $this->data);
        echo view('post');
        echo view('admin-footer');
    }

    protected function slug($text)
    {
        $slug = url_title(convert_accented_characters($text), '-', true);
        //check existing slug
        $builder = $this->db->table('post');
        $builder->select('slug');
        $builder->where('slug', $slug);
        $result = $builder->get()->getRow();
        if ($result) $slug = increment_string($slug, '_');
        return $slug;
    }

    public function new()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //retrieve category data
        $builder = $this->db->table('category');
        $builder->where('status', '1');
        $builder->orderBy('name');
        $result = $builder->get()->getResultArray();
        $this->data['categories'] = $result;

        //retrieve user data
        $builder->resetQuery();
        $builder = $this->db->table('user');
        $builder->orderBy('username');
        $result = $builder->get()->getResult();
        $this->data['users'] = $result;

        echo view('admin-header', $this->data);
        echo view('post-new');
        echo view('admin-footer');
    }

    public function addNew()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //get post form data
        $title          = $this->request->getPost('title');
        $slug           = $this->slug($title);
        $content        = $this->request->getPost('content');
        $category       = $this->request->getPost('category');
        $tags           = $this->request->getPost('tags');
        $author         = $this->request->getPost('author');
        $date_created   = $this->request->getPost('date') . date(' H:i:s', now());
        $last_modified  = $date_created;
        $status         = ($this->request->getPost('publish-now')) ? '1' : '0';
        $image          = $this->request->getFile('image');

        //processing multiple categories
        if ($category) {
            $category = implode(',', $category);
        } else {
            $category = '1';
        }

        //upload file image
        $name           = '';
        $onlyName       = '';
        $onlyExtension  = '';
        $path = ROOTPATH . 'public/upload/img/';
        if ($image->isValid() && !$image->hasMoved()) {
            // Generate a random name for the image
            $name = $image->getRandomName();

            // Move the image to the specified path with the generated name
            $image->move($path, $name);

            // Extract the name and extension of the image file
            $nameParts = pathinfo($name);
            $onlyName = $nameParts['filename'];
            $onlyExtension = $nameParts['extension'];

            // Resize the image and save it as a thumbnail
            $thumbnail = \Config\Services::image();
            $thumbnail->withFile($path . $name)
                ->resize(350, 350, true, 'width')
                ->save($path . $onlyName . '_thumb.' . $onlyExtension);

            // Initialize Google Cloud Storage client
            $storage = new StorageClient([
                'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
                'projectId' => 'diskominfo-wonosobo',
            ]);

            // Specify the bucket and file names in GCS
            $bucketName = 'dikpora';
            $objectName = 'upload/img/' . $name;
            $thumbnailObjectName = 'upload/img/' . $onlyName . '_thumb.' . $onlyExtension;

            // Upload the original image to GCS
            $bucket = $storage->bucket($bucketName);
            $bucket->upload(fopen($path . $name, 'r'), [
                'name' => $objectName,
            ]);

            // Upload the thumbnail to GCS
            $bucket->upload(fopen($path . $onlyName . '_thumb.' . $onlyExtension, 'r'), [
                'name' => $thumbnailObjectName,
            ]);

            // Delete the local temporary files
            unlink($path . $name);
            unlink($path . $onlyName . '_thumb.' . $onlyExtension);

            // Set image URLs as the final result
            // $image = $imageUrl;
            $image = $thumbnailObjectName;
        } else {
            $image = ''; // or any other appropriate handling
        }


        //table data
        $data = [
            'ID'             => null,
            'ID_user'        => $author,
            'ID_category'    => $category,
            'title'          => trim($title),
            'slug'           => $slug,
            'content'        => $content,
            'tags'           => $tags,
            'featured_image' => $image,
            'date_created'   => $date_created,
            'last_modified'  => $last_modified,
            'hits'           => 0,
            'status'         => $status,
        ];

        //send to database
        $builder = $this->db->table('post');
        $builder->insert($data);

        //check if inserted
        $alert = [];
        if ($this->db->affectedRows() > 0) {
            $alert = [
                'type'      => 'success',
                'message'   => 'Berhasil menyimpan artikel baru.'
            ];
        } else {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal menyimpan artikel baru!'
            ];
        }

        session()->setFlashdata('alert', $alert);
        return redirect()->to('post');
    }

    public function edit()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        $id = $this->request->getGet('id');
        //retrieve post data
        $builder = $this->db->table('post');
        $builder->where('ID', $id);
        $result = $builder->get()->getRow();
        if (!$result) return redirect()->to('post');
        $this->data['post'] = $result;

        //retrieve category data
        $builder->resetQuery();
        $builder = $this->db->table('category');
        $builder->where('status', '1');
        $builder->orderBy('name');
        $result = $builder->get()->getResultArray();
        $this->data['categories'] = $result;

        //retrieve user data
        $builder->resetQuery();
        $builder = $this->db->table('user');
        $builder->orderBy('username');
        $result = $builder->get()->getResult();
        $this->data['users'] = $result;

        echo view('admin-header', $this->data);
        echo view('post-edit');
        echo view('admin-footer');
    }

    public function update()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //get post form data
        $id             = $this->request->getPost('id');
        $title          = $this->request->getPost('title');
        $slug           = $this->slug($title);
        $content        = $this->request->getPost('content');
        $category       = $this->request->getPost('category');
        $tags           = $this->request->getPost('tags');
        $author         = $this->request->getPost('author');
        $date_created   = $this->request->getPost('date') . date(' H:i:s', now());
        $last_modified  = date('Y-m-d H:i:s', now());
        $status         = ($this->request->getPost('publish-now')) ? '1' : '0';
        $image_old      = $this->request->getPost('image-old');
        $image          = $this->request->getFile('image');

        //processing multiple categories
        if ($category) {
            $category = implode(',', $category);
        } else {
            $category = '1';
        }

        //upload file image
        $name           = '';
        $onlyName       = '';
        $onlyExtension  = '';
        $path = ROOTPATH . 'public/upload/img/';
        if ($image->isValid() && !$image->hasMoved()) {
            // Generate a random name for the image
            $name = $image->getRandomName();

            // Move the image to the specified path with the generated name
            $image->move($path, $name);

            // Extract the name and extension of the image file
            $nameParts = pathinfo($name);
            $onlyName = $nameParts['filename'];
            $onlyExtension = $nameParts['extension'];

            // Resize the image and save it as a thumbnail
            $thumbnail = \Config\Services::image();
            $thumbnail->withFile($path . $name)
                ->resize(350, 350, true, 'width')
                ->save($path . $onlyName . '_thumb.' . $onlyExtension);

            // Initialize Google Cloud Storage client
            $storage = new StorageClient([
                'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
                'projectId' => 'diskominfo-wonosobo',
            ]);

            // Specify the bucket and file names in GCS
            $bucketName = 'dikpora';
            $objectName = 'upload/img/' . $name;
            $thumbnailObjectName = 'upload/img/' . $onlyName . '_thumb.' . $onlyExtension;

            // Upload the original image to GCS
            $bucket = $storage->bucket($bucketName);
            $bucket->upload(fopen($path . $name, 'r'), [
                'name' => $objectName,
            ]);

            // Upload the thumbnail to GCS
            $bucket->upload(fopen($path . $onlyName . '_thumb.' . $onlyExtension, 'r'), [
                'name' => $thumbnailObjectName,
            ]);

            // Delete the local temporary files
            unlink($path . $name);
            unlink($path . $onlyName . '_thumb.' . $onlyExtension);

            // Set image URLs as the final result
            // $image = $imageUrl;
            $image = $thumbnailObjectName;
        } else {
            $image = $image_old;
        }

        //table data
        $data = [
            'ID_user'        => $author,
            'ID_category'    => $category,
            'title'          => trim($title),
            //'slug'           => $slug,
            'content'        => $content,
            'tags'           => $tags,
            'featured_image' => $image,
            'date_created'   => $date_created,
            'last_modified'  => $last_modified,
            'status'         => $status,
        ];

        //send to database
        $builder = $this->db->table('post');
        $builder->where('ID', $id);
        $builder->update($data);

        //check if inserted
        $alert = [];
        if ($this->db->affectedRows() > 0) {
            $alert = [
                'type'      => 'success',
                'message'   => 'Berhasil memperbaharui artikel.'
            ];
        } else {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal memperbaharui artikel!'
            ];
        }

        session()->setFlashdata('alert', $alert);
        return redirect()->to('post');
    }

    public function editStatus()
    {
        $id     = $this->request->getGet('id');
        $status = $this->request->getGet('status');

        $builder = $this->db->table('post');
        $builder->set('status', $status);
        $builder->where('ID', $id);
        $builder->update();

        $stat = ($status === '0') ? 'menghapus' : 'merestore';
        if ($this->db->affectedRows() > 0) {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => "Berhasil {$stat} postingan yang dipilih.",
            ]);
        } else {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => "Gagal {$stat} postingan yang dipilih!",
            ]);
        }
        return redirect()->back();
    }

    public function article($slug)
    {
        $news_ID_category = 6;
        //retrieve post data
        $builder = $this->db->table('post');
        $builder->where('slug', $slug);
        $builder->where('status', '1');
        $result = $builder->get()->getRow();
        //redirect to search if not found
        if (!$result) return redirect()->to('https://www.google.com/search?q=' . urlencode(str_replace('-', ' ', $slug . ' dikpora wonosobo')));
        $this->data['article'] = $result;

        //get comments
        $myComment = getPostCommentArray($result->ID, $this->db, 'ASC');
        $myComment = commentTreeRow($myComment);
        $myComment = json_decode(json_encode($myComment));
        $this->data['comments'] = $myComment;

        //3 new article
        $builder->resetQuery();
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        $builder->whereNotIn('ID', [$result->ID]);
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        //read the categories it has
        $categories = explode(',', $result->ID_category);
        $builder->resetQuery();
        $builder = $this->db->table('category');
        $builder->whereIn('ID', $categories);
        $builder->orderBy('name');
        $result = $builder->get()->getResult();
        $this->data['categories'] = $result;

        //add hits counter to this post
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->where('slug', $slug);
        $builder->set('hits', 'hits+1', false);
        $builder->update();

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
        echo view('article');
        echo view('footer');
    }

    public function archive($ID_category = 0)
    {
        $IDs = [];
        $Cat = 'Arsip Artikel';
        $keywords = trim($this->request->getGet('keywords'));

        $builder = $this->db->table('category');
        $builder->where('ID', $ID_category);
        $result = $builder->get()->getRow();
        if ($result) $Cat = 'Arsip: ' . $result->name;

        //retrieve ID_category
        $builder->resetQuery();
        $builder = $this->db->table('post');
        if ($ID_category) {
            //retrieve all ID_category
            $builder->select('ID,ID_category');
            $builder->where('status', '1');
            $result = $builder->get()->getResult();
            foreach ($result as $res) {
                $ID_cats = explode(',', $res->ID_category);
                if (in_array($ID_category, $ID_cats)) $IDs[] = $res->ID;
            }
        }

        //query
        $builder->resetQuery();
        $builder->selectCount('ID');
        $builder->where('status', '1');
        if ($keywords) {
            $builder->groupStart()
                ->like('title', $keywords)
                ->orLike('content', $keywords)
                ->orLike('tags', $keywords)
                ->groupEnd();
        }
        if ($ID_category) $builder->whereIn('ID', $IDs);
        $result = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($this->request->getGet('page') ?? 1);
        $perPage    = 20;
        $total      = $result->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page - 1) * $perPage;

        //reset query with pagination
        $builder->resetQuery();
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        if ($ID_category) $builder->whereIn('ID', $IDs);
        if ($keywords) {
            $builder->groupStart()
                ->like('title', $keywords)
                ->orLike('content', $keywords)
                ->orLike('tags', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('date_created', 'DESC');
        if ($page) $builder->limit($perPage, $this->data['pagerStart']);
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
        $obj->title     = $Cat;
        $obj->slugs     = url_title(strtolower($Cat), '-');
        $obj->content   = $Cat;
        $obj->tags      = 'arsip pengumuman, arsip berita, arsip, arsip dpupr';
        $this->data['article'] = $obj;

        /** visitor adn views count
        doVisitation($this->db);
        doView($this->db); */

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
        echo view('archive');
        echo view('footer');
    }

    public function search()
    {
        $keywords = trim($this->request->getGet('keywords'));

        $builder = $this->db->table('post');
        $builder->selectCount('ID');
        $builder->where('status', '1');
        if ($keywords) {
            $builder->groupStart()
                ->like('title', $keywords)
                ->orLike('content', $keywords)
                ->orLike('tags', $keywords)
                ->groupEnd();
        }
        $result = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($this->request->getGet('page') ?? 1);
        $perPage    = 20;
        $total      = $result->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page - 1) * $perPage;

        //reset query with pagination
        $builder->resetQuery();
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        if ($keywords) {
            $builder->groupStart()
                ->like('title', $keywords)
                ->orLike('content', $keywords)
                ->orLike('tags', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('date_created', 'DESC');
        if ($page) $builder->limit($perPage, $this->data['pagerStart']);
        $result = $builder->get()->getResult();
        $this->data['posts'] = $result;

        //3 new article
        $builder->resetQuery();
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        //acting like article attr
        $obj = new \stdClass();
        $obj->title     = 'Pencarian: ' . $keywords;
        $obj->slugs     = url_title(strtolower('Pencarian: ' . $keywords), '-');
        $obj->content   = 'Pencarian: ' . $keywords;
        $obj->tags      = 'pencarian, cari, telusur, telusuri berita';
        $this->data['article'] = $obj;

        /** visitor adn views count
        doVisitation($this->db);
        doView($this->db); */

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
        echo view('archive');
        echo view('footer');
    }
}
