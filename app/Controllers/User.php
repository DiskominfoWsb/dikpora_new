<?php

namespace App\Controllers;

class User extends BaseController
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

        $this->data['controller'] = 'user';

        //nav menu badge
        $this->data['unapproveService'] = unapproveServiceCount($this->db);
        $this->data['unapproveComment'] = unapproveCommentCount($this->db);

        //sidebar categories
        $this->data['categoriesList'] = getCategories($this->db);
        //sidebar popular tag
        $this->data['popularTags'] = getTags($this->db);

        //comment form
        $this->data['attachComment'] = 1;
    }

    public function index()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');
        if(session()->level > 2) return redirect()->back();

        //check search form
        $keywords   = trim($this->request->getGet('keywords'));

        //retrieve posts data
        $builder = $this->db->table('user');
        if($keywords)
        {
            $builder->groupStart()
                ->like('username', $keywords)
                ->orLike('full_name', $keywords)
                ->orLike('email', $keywords)
                ->orLike('birth_date', $keywords)
                ->groupEnd();
        }
        $result = $builder->get()->getResult();
        $this->data['users'] = $result;

        echo view('admin-header', $this->data);
        echo view('user');
        echo view('admin-footer');
    }

    public function new()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        $email      = $this->request->getPost('email');
        $username   = $this->request->getPost('username');
        $name       = $this->request->getPost('name');
        $password   = $this->request->getPost('password');
        $confirm    = $this->request->getPost('confirmation');
        $place      = $this->request->getPost('place');
        $date       = $this->request->getPost('date');
        $level      = $this->request->getPost('level');

        $data = [
            'ID'            => null,
            'username'      => trim($username),
            'password'      => $password,
            'full_name'     => trim($name),
            'gender'        => 'm',
            'birth_place'   => trim($place),
            'birth_date'    => trim($date),
            'email'         => trim($email),
            'token'         => '',
            'level'         => $level,
        ];

        $alert = [];
        if($username == '' || $email == '' || $name == '' || $password == '' || $confirm == '')
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Formulir isian kurang lengkap!',
            ];
        }
        elseif($password != $confirm)
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Konfirmasi password tidak sama!',
            ];
        }
        else
        {
            $data['password'] = password_hash($confirm, PASSWORD_BCRYPT, ['cost' => 11]);
            $builder = $this->db->table('user');
            $builder->insert($data);
            if($this->db->affectedRows() > 0)
            {
                $alert = [
                    'type'      => 'success',
                    'message'   => 'Berhasil menambahkan user baru.',
                ];
            }
            else
            {
                $alert = [
                    'type'      => 'danger',
                    'message'   => 'Gagal menambahkan user baru! Username/email sudah terpakai.',
                ];
            }
        }
        session()->setFlashdata('alert', $alert);
        return redirect()->back();

    }

    public function delete()
    {
        $alert = [];
        //always check
        if(!session()->ID) return redirect()->back();
        if(session()->level > 1)
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal menghapus user! Anda tidak memiliki akses.',
            ];
            session()->setFlashdata('alert', $alert);
            return redirect()->back();
        }

        $id = $this->request->getGet('id');
        $builder = $this->db->table('user');
        $builder->where('ID', $id);
        $builder->where('ID !=', 1); //avoid superadmin id hack
        $builder->delete();
        if($this->db->affectedRows() > 0)
        {
            $builder->resetQuery();
            $builder = $this->db->table('post');
            $builder->set('ID_user', 1);
            $builder->where('ID_user', $id);
            $builder->update();

            $builder->resetQuery();
            $builder = $this->db->table('page');
            $builder->set('ID_user', 1);
            $builder->where('ID_user', $id);
            $builder->update();

            $alert = [
                'type'      => 'success',
                'message'   => 'Berhasil menghapus satu user.',
            ];
            session()->setFlashdata('alert', $alert);
            return redirect()->back();
        }
        else
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Gagal menghapus user!',
            ];
            session()->setFlashdata('alert', $alert);
            return redirect()->back();
        }
    }

    public function edit()
    {
        $ID     = $this->request->getPOST('ID');
        $id     = $this->request->getPOST('id');

        $builder = $this->db->table('user');
        $builder->where('ID', $id);
        $result = $builder->get()->getRowArray();

        if($ID)
        {
            echo json_encode($result);
        }
        else
        {
            echo json_encode([]);
        }
    }

    public function update()
    {
        //always check authentication
        if (!session()->ID) return redirect()->to('login');

        $id         = $this->request->getPost('id');
        $email      = $this->request->getPost('email');
        $username   = $this->request->getPost('username');
        $name       = $this->request->getPost('name');
        $password   = $this->request->getPost('password');
        $confirm    = $this->request->getPost('confirmation');
        $place      = $this->request->getPost('place');
        $date       = $this->request->getPost('date');
        $level      = $this->request->getPost('level');

        $data = [
            'username'      => trim($username),
            'full_name'     => trim($name),
            'gender'        => 'm',
            'birth_place'   => trim($place),
            'birth_date'    => trim($date),
            'email'         => trim($email),
            'token'         => '',
            'level'         => $level,
        ];

        $alert = [];
        if($username == '' || $email == '' || $name == '')
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Formulir isian kurang lengkap!',
            ];
        }
        elseif($password && $password != $confirm)
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Konfirmasi password tidak sama!',
            ];
        }
        elseif($confirm && $password != $confirm)
        {
            $alert = [
                'type'      => 'danger',
                'message'   => 'Konfirmasi password tidak sama!',
            ];
        }
        else
        {
            if($password && $confirm)
            {
                if($password == $confirm)
                {
                    $data['password'] = password_hash($confirm, PASSWORD_BCRYPT, ['cost' => 11]);
                }
            }
            $builder = $this->db->table('user');
            $builder->where('ID', $id);
            $builder->update($data);
            if($this->db->affectedRows() > 0)
            {
                $alert = [
                    'type'      => 'success',
                    'message'   => 'Berhasil memperbaharui user.',
                ];
            }
            else
            {
                $alert = [
                    'type'      => 'danger',
                    'message'   => 'Tidak ada perubahan data user!',
                ];
            }
        }
        session()->setFlashdata('alert', $alert);
        return redirect()->back();

    }

}