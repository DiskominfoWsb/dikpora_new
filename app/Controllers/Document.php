<?php

namespace App\Controllers;

class Document extends BaseController
{
    protected $db;
    protected $data = [];

    protected $subcategory = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper([
            'date', 'my_date', 'text', 'security', 'page',
            'option','menu','category','service', 'comment',
            'counter',
        ]);

        $this->data['controller'] = 'document';

        $list   = [];
        $listKu = json_decode(getOption('jenis_transparansi', $this->db), true);
        if($listKu)
        {
            array_multisort(
                array_column($listKu, 'title'),
                SORT_ASC,
                $listKu
            );
            $list = $listKu;
        }
        $this->subcategory = $list;

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

        //retrieve data
        $category = $this->request->getGet('category');
        $category = (strtolower($category) == 'transparansi') ? 'transparansi' : 'umum';
        $builder = $this->db->table('document');
        $builder->where('category', $category);


        //3 new article
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        echo view('admin-header', $this->data);
        echo view("document-{$category}");
        echo view('admin-footer');
    }

    public function new()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //check status
        $status = $this->request->getGet('status');
        $status = ($status === '0') ? '0' : '1';

        //retrieve data
        $category = $this->request->getGet('category');
        $category = (strtolower($category) == 'transparansi') ? 'transparansi' : 'umum';
        $this->data['category'] = $category;
        $this->data['subcategory'] = $this->subcategory;

        //filter form get method
        $subcategory    = $this->request->getGet('sub-category');
        $fiscal         = $this->request->getGet('fiscal');
        $keywords       = $this->request->getGet('keywords');

        //query
        $builder = $this->db->table('document');
        $builder->selectCount('ID');
        $builder->where('category', $category);
        $builder->where('status', $status);
        if($subcategory) $builder->where('sub_category', $subcategory);
        if($fiscal) $builder->where('fiscal', $fiscal);
        if(trim($keywords)) $builder->like('title', $keywords);
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

        //reset query with pagination
        $builder->resetQuery();
        $builder = $this->db->table('document');
        $builder->where('category', $category);
        $builder->where('status', $status);
        if($subcategory) $builder->where('sub_category', $subcategory);
        if($fiscal) $builder->where('fiscal', $fiscal);
        if(trim($keywords)) $builder->like('title', $keywords);
        if($page) $builder->limit($perPage, $this->data['pagerStart']);
        $builder->orderBy('date_uploaded', 'DESC');
        $result = $builder->get()->getResult();
        $this->data['document'] = $result;

        //acting like article attr
        $obj = new \stdClass();
        $obj->title     = 'Transparansi Anggaran';
        $obj->slugs     = 'transparansi-anggaran';
        $obj->content   = 'Transparansi Anggaran Dikpora Kabupaten Wonosobo';
        $obj->tags      = 'transparansi,anggaran,disdikpora,wonosobo';
        $this->data['article'] = $obj;

        //filter form
        $this->data['subcategory'] = $this->subcategory;
        //fiscal
        $builder->resetQuery();
        $builder = $this->db->table('document');
        $builder->select('fiscal');
        $builder->where('category', 'transparansi');
        $builder->groupBy('fiscal');
        $builder->orderBy('fiscal', 'DESC');
        $result = $builder->get()->getResult();
        $this->data['fiscal'] = $result;

        echo view('admin-header', $this->data);
        echo view('document-new');
        echo view('admin-footer');
    }

    public function addNew()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //get post form data
        $title          = $this->request->getPost('title');
        $description    = $this->request->getPost('description');
        $category       = $this->request->getPost('category');
        $subcategory    = $this->request->getPost('sub-category');
        $fiscal         = $this->request->getPost('fiscal');
        $date_uploaded  = $this->request->getPost('date').date(' H:i:s', now());
        $status         = ($this->request->getPost('publish-now')) ? '1' : '0';
        $file           = $this->request->getFile('file');
        $linkExternal   = trim($this->request->getPost('link-external'));
        $url            = '#';

        //upload file first
        if($file->isValid() && !$file->hasMoved())
        {
            $path   = ROOTPATH . 'public/upload/doc/';
            $name   = $file->getRandomName();
            $file->move($path, $name);
            $url    = base_url('upload/doc/'.$name);
        }
        else
        {
            if($linkExternal) $url = $linkExternal;
        }

        $data = [
            'ID'            => null,
            'ID_user'       => session()->ID,
            'title'         => trim($title),
            'description'   => $description,
            'url'           => $url,
            'category'      => $category,
            'sub_category'  => $subcategory,
            'fiscal'        => $fiscal,
            'date_uploaded' => $date_uploaded,
            'status'        => $status,
        ];
        //inserting data
        $builder = $this->db->table('document');
        $builder->insert($data);

        //check if inserted
        $alert = [];
        if($this->db->affectedRows() > 0)
        {
            $alert = [
                'type'      => 'success',
                'message'   => 'Berhasil menyimpan dokumen baru.'
            ];
        }
        else
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal menyimpan dokumen baru!'
            ];
        }

        session()->setFlashdata('alert', $alert);
        return redirect()->to('document/new?category='.$category);
    }

    public function editStatus()
    {
        $id     = $this->request->getGet('id');
        $status = $this->request->getGet('status');

        $builder = $this->db->table('document');
        $builder->set('status', $status);
        $builder->where('ID', $id);
        $builder->update();

        $stat = ($status === '0') ? 'menghapus' : 'merestore';
        if($this->db->affectedRows() > 0)
        {
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

    public function transparansi()
    {
        //filter form get method
        $subcategory    = $this->request->getGet('sub-category');
        $fiscal         = $this->request->getGet('fiscal');
        $keywords       = $this->request->getGet('keywords');

        //query
        $builder = $this->db->table('document');
        $builder->selectCount('ID');
        $builder->where('category', 'transparansi');
        $builder->where('status', '1');
        if($subcategory) $builder->where('sub_category', $subcategory);
        if($fiscal) $builder->where('fiscal', $fiscal);
        if(trim($keywords)) $builder->like('title', $keywords);
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

        //reset query with pagination
        $builder->resetQuery();
        $builder = $this->db->table('document');
        $builder->where('category', 'transparansi');
        $builder->where('status', '1');
        if($subcategory) $builder->where('sub_category', $subcategory);
        if($fiscal) $builder->where('fiscal', $fiscal);
        if(trim($keywords)) $builder->like('title', $keywords);
        if($page) $builder->limit($perPage, $this->data['pagerStart']);
        $builder->orderBy('title', 'ASC');
        $result = $builder->get()->getResult();
        $this->data['document'] = $result;

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
        $obj->title     = 'Transparansi Anggaran';
        $obj->slugs     = 'transparansi-anggaran';
        $obj->content   = 'Transparansi Anggaran Disdikpora Kabupaten Wonosobo';
        $obj->tags      = 'transparansi,anggaran,disdikpora,wonosobo';
        $this->data['article'] = $obj;

        //filter form
        $this->data['subcategory'] = $this->subcategory;
        //fiscal
        $builder->resetQuery();
        $builder = $this->db->table('document');
        $builder->select('fiscal');
        $builder->where('category', 'transparansi');
        $builder->groupBy('fiscal');
        $builder->orderBy('fiscal', 'DESC');
        $result = $builder->get()->getResult();
        $this->data['fiscal'] = $result;

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
        echo view('transparansi');
        echo view('footer');
    }

    public function umum()
    {
        //filter form get method
        $keywords       = $this->request->getGet('keywords');

        //query
        $builder = $this->db->table('document');
        $builder->selectCount('ID');
        $builder->where('category', 'umum');
        $builder->where('sub_category', 'lainnya');
        $builder->where('status', '1');
        if(trim($keywords))
        {
            $keywords = trim($keywords);
            $builder->groupStart()
                ->like('title', $keywords)
                ->orLike('description', $keywords)
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
        $this->data['pagerStart']   = ($page-1)*$perPage;

        //reset query with pagination
        $builder->resetQuery();
        $builder = $this->db->table('document');
        $builder->where('category', 'umum');
        $builder->where('sub_category', 'lainnya');
        $builder->where('status', '1');
        if(trim($keywords))
        {
            $keywords = trim($keywords);
            $builder->groupStart()
                ->like('title', $keywords)
                ->orLike('description', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('date_uploaded', 'DESC');
        $result = $builder->get()->getResult();
        $this->data['document'] = $result;

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
        $obj->title     = 'Download Area';
        $obj->slugs     = 'download-area';
        $obj->content   = 'Download Area Disdikpora Kabupaten Wonosobo';
        $obj->tags      = 'download,unduh,disdikpora,wonosobo';
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

        echo view('header', $this->data);
        echo view('download');
        echo view('footer');
    }

    public function getJenisTransparansi()
    {
        $list = [];
        $option_name = $this->request->getGet('option_name');
        $list = json_decode(getOption($option_name, $this->db), true);
        if($list)
        {
            array_multisort(
                array_column($list, 'title'),
                SORT_ASC,
                $list
            );
        }
        echo json_encode($list);
    }

    public function addJenisTransparansi()
    {
        $title  = $this->request->getGet('title');
        $slug   = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $option = json_decode(getOption('jenis_transparansi', $this->db), true);
        array_push($option, ['title'=>$title, 'slug'=>$slug]);
        updateOption('jenis_transparansi', json_encode($option), $this->db);
    }

    public function dropJenisTransparansi()
    {
        $slug       = $this->request->getGet('slug');
        $newOption  = [];
        $option     = json_decode(getOption('jenis_transparansi', $this->db));
        foreach($option as $o)
        {
            if($o->slug != $slug) array_push($newOption, [
                'title' => $o->title,
                'slug'  => $o->slug,
            ]);
        }
        updateOption('jenis_transparansi', json_encode($newOption), $this->db);
    }

}