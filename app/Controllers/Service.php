<?php

namespace App\Controllers;

use Google\Cloud\Storage\StorageClient;

class Service extends BaseController
{
    protected $db;
    protected $data = [];
    
    protected $path;
    protected $url;
    protected $name;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper([
            'date', 'my_date', 'text', 'security', 'page',
            'option', 'menu', 'category', 'service', 'comment',
            'counter',
        ]);

        $this->data['controller'] = 'service';

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

        $this->path = ROOTPATH . 'public/upload';
        $this->url  = base_url('upload');
    }

    public function index()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //get filter keywords search
        $category = trim($this->request->getGet('category'));
        $keywords = trim($this->request->getGet('keywords'));

        //query
        $builder = $this->db->table('service');
        $builder->selectCount('ID');
        if ($category) $builder->where('category', $category);
        if ($keywords) {
            $builder->groupStart()
                ->like('name', $keywords)
                ->orLike('message', $keywords)
                ->orLike('comment', $keywords)
                ->groupEnd();
        }
        $result = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($this->request->getGet('page') ?? 1);
        $perPage    = 25;
        $total      = $result->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page - 1) * $perPage;

        //reset query with pagination
        $builder->resetQuery();
        if ($category) $builder->where('category', $category);
        if ($keywords) {
            $builder->groupStart()
                ->like('name', $keywords)
                ->orLike('message', $keywords)
                ->orLike('comment', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('date_submit', 'DESC');
        $result = $builder->get()->getResult();
        $this->data['messages'] = $result;

        echo view('admin-header', $this->data);
        echo view('service');
        echo view('admin-footer');
    }

    private function getMessage($category, $rpage)
    {
        $builder = $this->db->table('service');
        $builder->selectCount('ID');
        $builder->where('category', $category);
        $builder->where('status', '1');
        $result = $builder->get()->getRow();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($rpage ?? 1);
        $perPage    = 7;
        $total      = $result->ID;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page - 1) * $perPage;

        //reset query with paged
        $builder->resetQuery();
        $builder->where('category', $category);
        $builder->where('status', '1');
        $builder->orderBy('date_submit', 'DESC');
        $builder->limit($perPage, $this->data['pagerStart']);
        $result = $builder->get()->getResult();

        return $result;
    }

    public function pengaduan()
    {
        //3 new article
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        //acting like article attr
        $obj = new \stdClass();
        $obj->title     = 'Layanan Pengaduan Masyarakat';
        $obj->slugs     = 'layanan-pengaduan-masyarakat';
        $obj->content   = 'Layanan Online Pengaduan Masyarakat';
        $obj->tags      = 'layanan,pengaduan';
        $this->data['article'] = $obj;

        $this->data['pengaduan'] = $this->getMessage('pengaduan', $this->request->getGet('page'));

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
        echo view('layanan-pengaduan');
        echo view('footer');
    }

    public function permohonan()
    {
        //3 new article
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(3);
        $results = $builder->get()->getResult();
        $this->data['featured'] = $results;

        //acting like article attr
        $obj = new \stdClass();
        $obj->title     = 'Layanan Permohonan Informasi';
        $obj->slugs     = 'layanan-permohonan-informasi';
        $obj->content   = 'Layanan Online Permohonan Informasi';
        $obj->tags      = 'layanan,informasi';
        $this->data['article'] = $obj;

        $this->data['permohonan'] = $this->getMessage('permohonan', $this->request->getGet('page'));

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
        echo view('layanan-informasi');
        echo view('footer');
    }

    private function post($data)
    {
        $builder = $this->db->table('service');
        $builder->insert($data);
        return $this->db->affectedRows();
    }

    public function kirim()
    {
        //check reCAPTCHA
        $response = $this->request->getPost('g-recaptcha-response');
        if (!$response) {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Silahkan centang <strong>I\'m not a robot</strong> / <strong>Saya bukan robot</strong>',
            ]);
            return redirect()->back();
        }

        //check response
        /** Google reCaptcha v2 */
        $url        = 'https://www.google.com/recaptcha/api/siteverify';
        $key        = '6LdK2yoiAAAAAPVB28ijfWfD5fAwCDvjVgGeuGfn';
        $postdata   = http_build_query([
            'secret'    => $key,
            'response'  => $response,
        ]);
        $option = [
            'http'  => [
                'method'    => 'POST',
                'header'    => 'Content-type: application/x-www-form-urlencoded',
                'content'   => $postdata,
            ],
        ];
        $context    = stream_context_create($option);
        $recaptcha  = file_get_contents($url, false, $context);
        $recaptcha  = json_decode($recaptcha, true);
        //take action if not success
        if (!$recaptcha['success']) {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Terdeteksi adanya malware! <em>' . $recaptcha['error-codes'] . '</em>',
            ]);
            return redirect()->back();
        }
        /** -- end Google reCaptcha v2 -- */

        //post service data
        $category    = trim($this->request->getPost('category'));
        $name        = trim($this->request->getPost('name'));
        $profession  = trim($this->request->getPost('profession'));
        $address     = trim($this->request->getPost('address'));
        $_rt         = trim($this->request->getPost('_rt'));
        $_rw         = trim($this->request->getPost('_rw'));
        $_kelurahan  = trim($this->request->getPost('_kelurahan'));
        $_kecamatan  = trim($this->request->getPost('_kecamatan'));
        $email       = trim($this->request->getPost('email'));
        $phone       = trim($this->request->getPost('phone'));
        $purpose     = trim($this->request->getPost('purpose'));
        $message     = trim($this->request->getPost('message'));
        $attachment  = '';
        $comment     = '';
        $date_submit = date('Y-m-d H:i:s', now());
        $status      = '0';

        //check required field
        if (empty($name) or empty($profession) or empty($address) or empty($_kelurahan) or empty($_kecamatan) or empty($email) or empty($message)) {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Isian formulir tidak lengkap!',
            ]);
            return redirect()->back();
        }
        //check email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Alamat email tidak valid!',
            ]);
            return redirect()->back();
        }

        //uploading file
        $allowedExtension = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $file   = $this->request->getFile('file');
        $ext    = $file->getClientExtension();
        if (in_array($ext, $allowedExtension)) {
            if ($file->isValid() && !$file->hasMoved()) {
                $oke   = $this->uploadToGCS($file, 'upload/img');
                $attachment = site_url('upload/view?file=' . $oke);
            }
        }


        //insert data
        $data = [
            'ID'            => null,
            'category'      => $category,
            'name'          => $name,
            'profession'    => $profession,
            'address'       => $address,
            '_rt'           => $_rt,
            '_rw'           => $_rw,
            '_kelurahan'    => $_kelurahan,
            '_kecamatan'    => $_kecamatan,
            'email'         => $email,
            'phone'         => $phone,
            'purpose'       => $purpose,
            'message'       => $message,
            'attachment'    => $attachment,
            'comment'       => $comment,
            'date_submit'   => $date_submit,
            'status'        => $status,
        ];
        if ($this->post($data)) {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Pesan anda berhasil dikirim dan menunggu respon admin.',
            ]);
            return redirect()->back();
        } else {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal mengirimkan pesan! Periksa koneksi Anda.',
            ]);
            return redirect()->back();
        }
    }

    protected function uploadToGCS($file, $folder)
    {
        // Generate a random name for the file
        $name = $file->getRandomName();

        // Move the file to the specified path with the generated name
        $file->move($this->path . $folder, $name);

        // Initialize Google Cloud Storage client
        $storage = new StorageClient([
            'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
            'projectId' => 'diskominfo-wonosobo',
        ]);

        // Specify your GCS bucket
        $bucket = $storage->bucket('dikpora');

        // Specify the file path in GCS
        $objectName = $folder . '/' . $name;

        // Upload the file to GCS
        $bucket->upload(
            fopen($this->path . $objectName, 'r'),
            [
                'name' => $objectName
            ]
        );

        // Delete the local copy
        unlink($this->path . $objectName);

        // Return the GCS file path
        return $objectName;
    }

    private function updateStatus($id, $status)
    {
        $builder = $this->db->table('service');
        $builder->set('status', $status);
        $builder->where('ID', $id);
        $builder->update();
        return $this->db->affectedRows();
    }

    public function approve()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //get id
        $id = $this->request->getGet('id');
        //update status
        if ($this->updateStatus($id, '1')) {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil meng-approve satu pesan.',
            ]);
        } else {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal meng-approve satu pesan!',
            ]);
        }
        return redirect()->back();
    }

    public function unapprove()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //get id
        $id = $this->request->getGet('id');
        //update status
        if ($this->updateStatus($id, '0')) {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil meng-unapprove satu pesan.',
            ]);
        } else {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal meng-unapprove satu pesan!',
            ]);
        }
        return redirect()->back();
    }

    public function reply()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        //get id
        $id     = $this->request->getPost('id');
        $text   = trim($this->request->getPost('comment'));
        //update comment
        $builder = $this->db->table('service');
        $builder->set('comment', $text);
        $builder->where('ID', $id);
        $builder->update();
        if ($this->db->affectedRows() > 0) {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil memperbaharui komentar balasan.',
            ]);
        } else {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal memperbaharui komentar balasan!',
            ]);
        }
        return redirect()->back();
    }
}
