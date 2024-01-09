<?php

namespace App\Controllers;

class Authentication extends BaseController
{
    public function index()
    {
        return redirect()->to(base_url('login'));
    }
    
    public function login()
    {
        $db         = \Config\Database::connect();
        helper(['date']);
        
        /** Google reCaptcha v3 */
        $url        = 'https://www.google.com/recaptcha/api/siteverify';
        $key        = '6LfWrPkhAAAAACaS07efTulkV7-1IsclBOrMUuK4';
        $response   = $this->request->getPost('g-recaptcha-response');
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
        //take action if low score
        if($recaptcha['success'])
        {
            if($recaptcha['score'] < 0.6)
            {
                session()->setFlashdata('alert', [
                    'type'      => 'danger',
                    'message'   => 'Terdeteksi adanya malware!',
                ]);
                redirect()->to('login');
            }
            else
            {
                //nothing to do
            }
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Terdeteksi adanya malware!',
            ]);
            redirect()->to('login');
        }
        /** -- end Google reCaptcha v3 -- */
        
        //getting form data
        $username   = $this->request->getPost('username');
        $password   = $this->request->getPost('password');
        $redirect   = ($this->request->getGet('redirect')) ? $this->request->getGet('redirect') : 'dashboard';

        $builder = $db->table('user');
        $usemail = (filter_var($username, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';
        $builder->where($usemail, $username);
        $result = $builder->get()->getRowArray();
        
        //check if exists
        if(!$result)
        {
            session()->setFlashdata('alert', [
                'type'      => 'danger',
                'message'   => 'Username tidak ditemukan!',
            ]);
            return redirect()->to('login');
        }
        else
        {
            if(!password_verify($password, $result['password']))
            {
                session()->setFlashdata('alert', [
                    'type'      => 'danger',
                    'message'   => 'Password tidak cocok!',
                ]);
                return redirect()->to('login');
            }
            else
            {
                $result['level'] = (int)$result['level'];
            }
        }

        if($this->request->getPost('remember'))
        {
            session()->setTempdata($result, null, 21600);
        }
        else
        {
            session()->set($result);
        }

        return redirect()->to($redirect);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
    
}