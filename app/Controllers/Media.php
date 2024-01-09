<?php

namespace App\Controllers;

class Media extends BaseController
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

        $this->data['controller'] = 'media';

        //nav menu badge
        $this->data['unapproveService'] = unapproveServiceCount($this->db);
        $this->data['unapproveComment'] = unapproveCommentCount($this->db);

    }

    public function index()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        $choice = strtolower($this->request->getGet('t'));
        if($choice == 'img') $this->data['imageFiles'] = $this->imageFiles($choice);
        if($choice == 'doc') $this->data['documentFiles'] = $this->documentFiles($choice);

        echo view('admin-header', $this->data);
        echo view('media');
        echo view('admin-footer');
    }

    protected function imageFiles($dir='img')
    {
        $images = [];
        $image  = scandir(ROOTPATH.'public/upload/'.$dir, SCANDIR_SORT_DESCENDING);
        foreach($image as $img)
        {
            if(!($img == '.' OR $img == '..' OR str_contains($img,'.php')))
            {
                if(!(str_contains($img,'_thumb') OR str_contains($img,'_min')))
                {
                    $myImage    = [];
                    $arrayName  = explode('.',$img);
                    $extension  = $arrayName[count($arrayName)-1]; //without .
                    $fakeThumb  = str_replace('.'.$extension, '_thumb.'.$extension, $img);
                    $fakeMini   = str_replace('.'.$extension, '_min.'.$extension, $img);
                    $myImage['fullname']    = $img; //without path
                    $myImage['original']    = base_url('upload/'.$dir.'/'.$img);
                    $myImage['fullthumb']   = $myImage['thumbnail'] = '';
                    if(file_exists(ROOTPATH.'public/upload/img/'.$fakeThumb))
                    {
                        $myImage['fullthumb'] = $fakeThumb;
                        $myImage['thumbnail'] = base_url('upload/'.$dir.'/'.$fakeThumb);
                    }
                    elseif(file_exists(ROOTPATH.'public/upload/'.$dir.'/'.$fakeMini))
                    {
                        $myImage['fullthumb'] = $fakeMini;
                        $myImage['thumbnail'] = base_url('upload/'.$dir.'/'.$fakeMini);
                    }
                    else
                    {
                        $myImage['thumbnail'] = base_url('upload/'.$dir.'/'.$img);
                    }
                    array_push($images, $myImage);
                }
            }
        }
        return $images;
    }

    protected function documentFiles($dir='doc')
    {
        $files = [];
        $file  = scandir(ROOTPATH.'public/upload/'.$dir, SCANDIR_SORT_DESCENDING);
        foreach($file as $fl)
        {
            if(!($fl == '.' OR $fl == '..' OR str_contains($fl,'.php')))
            {
                if(!(str_contains($fl,'_thumb') OR str_contains($fl,'_min')))
                {
                    $myFile     = [];
                    $arrayName  = explode('.',$fl);
                    $extension  = $arrayName[count($arrayName)-1]; //without .
                    $fakeThumb  = str_replace('.'.$extension, '_thumb.'.$extension, $fl);
                    $fakeMini   = str_replace('.'.$extension, '_min.'.$extension, $fl);
                    $myFile['fullname']     = $fl; //without path
                    $myFile['extension']    = $extension;
                    $myFile['original']     = base_url('upload/'.$dir.'/'.$fl);
                    $myFile['thumbnail']    = '';
                    if(file_exists(ROOTPATH.'public/upload/'.$dir.'/'.$fakeThumb))
                    {
                        $myFile['thumbnail'] = base_url('upload/'.$dir.'/'.$fakeThumb);
                    }
                    elseif(file_exists(ROOTPATH.'public/upload/'.$dir.'/'.$fakeMini))
                    {
                        $myFile['thumbnail'] = base_url('upload/'.$dir.'/'.$fakeMini);
                    }
                    else
                    {
                        $myFile['thumbnail'] = base_url('upload/'.$dir.'/'.$fl);
                    }
                    array_push($files, $myFile);
                }
            }
        }
        return $files;
    }

    public function delete()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        $t = $this->request->getGet('t');
        $t = strtolower(trim($t));
        $f = $this->request->getGet('f');
        $m = $this->request->getGet('m');

        $countMe = 0;

        if($f && file_exists(ROOTPATH.'public/upload/'.$t.'/'.$f))
        {
            unlink(ROOTPATH.'public/upload/'.$t.'/'.$f);
            $countMe++;
        }

        if($m && file_exists(ROOTPATH.'public/upload/'.$t.'/'.$m))
        {
            unlink(ROOTPATH.'public/upload/'.$t.'/'.$m);
            $countMe++;
        }

        if($countMe > 0)
        {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil menghapus '.$countMe.' berkas media.',
            ]);
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'warning',
                'message'   => 'Gagal hapus! Berkas media sudah tidak ada.',
            ]);
        }
        return redirect()->to('media?t='.$t);

    }

}