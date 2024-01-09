<?php

namespace App\Controllers;

class Comment extends BaseController
{
    protected $db;
    protected $data = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper([
            'date', 'my_date', 'text', 'security', 'page',
            'option','menu','category','service', 'comment',
        ]);

        $this->data['controller'] = 'comment';

        //nav menu badge
        $this->data['unapproveService'] = unapproveServiceCount($this->db);
        $this->data['unapproveComment'] = unapproveCommentCount($this->db);

    }

    public function index()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //get keywords filter
        $keywords = trim($this->request->getGet('keywords'));

        //query
        $builder = $this->db->table('comment');
        $builder->selectCount('ID');
        if($keywords)
        {
            $builder->groupStart()
                ->like('name', $keywords)
                ->orLike('message', $keywords)
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
        $this->data['pagerStart']   = ($page-1)*$perPage;

        //reset query with pagination
        $builder->resetQuery();
        if($keywords)
        {
            $builder->groupStart()
                ->like('name', $keywords)
                ->orLike('message', $keywords)
                ->groupEnd();
        }
        $builder->orderBy('date_submit', 'DESC');
        $result = $builder->get()->getResultArray();
        $result = commentTreeRow($result);
        $result = json_decode(json_encode($result));
        $this->data['comments'] = $result;

        //post and page title slug
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->select('ID,title,slug');
        $result = $builder->get()->getResult();
        $postku = [];
        foreach($result as $res)
        {
            $postku[$res->ID] = $res;
        }
        $builder->resetQuery();
        $builder = $this->db->table('page');
        $builder->select('ID,title,slug');
        $result = $builder->get()->getResult();
        $pageku = [];
        foreach($result as $res)
        {
            $pageku[$res->ID] = $res;
        }
        $this->data['postpage']['post'] = $postku;
        $this->data['postpage']['page'] = $pageku;

        echo view('admin-header', $this->data);
        echo view('comment');
        echo view('admin-footer');
    }

    private function getComment($type, $rpage)
    {
        $builder = $this->db->table('comment');
        $builder->select('ID');
        $builder->where('type', $type);
        $result = $builder->get()->getNumRows();

        //pagination
        $pager      = \Config\Services::pager();
        $page       = (int) ($rpage ?? 1);
        $perPage    = 7;
        $total      = $result;
        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
        $this->data['pager']        = $pager_links;
        $this->data['pagerStart']   = ($page-1)*$perPage;

        //reset query with paged
        $builder->resetQuery();
        $builder->where('type', $type);
        $builder->orderBy('date_submit', 'DESC');
        $builder->limit($perPage, $this->data['pagerStart']);
        $result = $builder->get()->getResult();

        return $result;
    }

    private function post($data)
    {
        $builder = $this->db->table('comment');
        $builder->insert($data);
        return $this->db->affectedRows();
    }

    public function kirim()
    {
        //check reCAPTCHA
        $response = $this->request->getPost('g-recaptcha-response');
        if(!$response)
        {
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
        if(!$recaptcha['success'])
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Terdeteksi adanya malware! <em>'.$recaptcha['error-codes'].'</em>',
            ]);
            return redirect()->back();
        }
        /** -- end Google reCaptcha v2 -- */

        //post service data
        $slug           = $this->request->getPost('slug');
        $id             = $this->request->getPost('id');
        $type           = $this->request->getPost('type');
        $name           = trim($this->request->getPost('name'));
        $email          = trim($this->request->getPost('email'));
        $phone          = trim($this->request->getPost('phone'));
        $message        = trim($this->request->getPost('message'));
        $date_submit    = date('Y-m-d H:i:s', now());
        $status         = '0';
        //artikel or halaman
        $preSlug = ($type == 'post') ? 'artikel' : 'halaman';

        //check required field
        if(empty($name) OR empty($email) OR empty($message))
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Isian formulir tidak lengkap!',
            ]);
            return redirect()->to("{$preSlug}/{$slug}".'#form-comment');
        }
        //check email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Alamat email tidak valid!',
            ]);
            return redirect()->to("{$preSlug}/{$slug}".'#form-comment');
        }

        //insert data
        $data = [
            'ID'            => null,
            'ID_comment'    => 0,
            'type'          => $type,
            'ID_post_page'  => $id,
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'message'       => $message,
            'date_submit'   => $date_submit,
            'status'        => $status,
        ];
        if($this->post($data))
        {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Komentar anda berhasil dikirim dan menunggu moderasi.',
            ]);
            return redirect()->to("{$preSlug}/{$slug}".'#form-comment');
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal mengirimkan komentar! Periksa koneksi Anda.',
            ]);
            return redirect()->to("{$preSlug}/{$slug}".'#form-comment');
        }
    }

    private function updateStatus($id, $status)
    {
        $builder = $this->db->table('comment');
        $builder->set('status', $status);
        $builder->where('ID', $id);
        $builder->update();
        return $this->db->affectedRows();
    }

    public function approve()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //get id
        $id = $this->request->getGet('id');
        //update status
        if($this->updateStatus($id, '1'))
        {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil meng-approve satu komentar.',
            ]);
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal meng-approve satu komentar!',
            ]);
        }
        return redirect()->back();
    }

    public function unapprove()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //get id
        $id = $this->request->getGet('id');
        //update status
        if($this->updateStatus($id, '0'))
        {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil meng-unapprove satu komentar.',
            ]);
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal meng-unapprove satu komentar!',
            ]);
        }
        return redirect()->back();
    }

    public function reply()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        $type   = $this->request->getPost('type');
        $id     = $this->request->getPost('id');
        $id_p   = $this->request->getPost('id_p');
        $text   = trim($this->request->getPost('comment'));

        //set data
        $data = [
            'ID'            => null,
            'ID_comment'    => $id,
            'type'          => $type,
            'ID_post_page'  => $id_p,
            'name'          => 'Admin',
            'email'         => 'dikpora@wonosobokab.go.id',
            'phone'         => '(0286) 321078',
            'message'       => $text,
            'date_submit'   => date('Y-m-d H:i:s', now()),
            'status'        => '1',
        ];

        //update comment
        $builder = $this->db->table('comment');
        $builder->insert($data);
        if($this->db->affectedRows() > 0)
        {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil mengirim balasan komentar.',
            ]);
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Gagal mengirim balasan komentar!',
            ]);
        }
        return redirect()->back();
    }

}