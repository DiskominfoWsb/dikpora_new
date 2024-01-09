<?php

namespace App\Controllers;

class Upload extends BaseController
{

    protected $path;
    protected $url;
    protected $name;

    public function __construct()
    {
        $this->path = ROOTPATH . 'public/upload';
        $this->url  = base_url('upload');
    }

    protected function general($field = 'upload', $folder = 'img')
    {
        $file = $this->request->getFile($field);
        //check if valid or moved
        if($file->isValid() && !$file->hasMoved())
        {
            $this->name = $file->getRandomName();
            $file->move($this->path.'/'.$folder, $this->name);
            return $this->name;
        }
        else
        {
            return null;
        }
    }

    public function imageFileEditor($field = 'upload')
    {
        $allowedExtension   = ['jpg','jpeg','png','gif','webp'];
        $videoExtension     = ['mp4','webm','ogv'];
        $CKEditorFuncNum    = $this->request->getGet('CKEditorFuncNum');
        $tempFile           = $this->request->getFile($field);
        $folder             = 'doc';
        if(in_array($tempFile->guessExtension(), $allowedExtension)) $folder = 'img';
        if(in_array($tempFile->guessExtension(), $videoExtension)) $folder = 'vid';
        $fileName           = $this->general($field, $folder);
        $url                = null;
        $message            = 'Failed uploading file!';
        $name               = explode('.', $fileName);
        $onlyName           = $name[0];
        $onlyExtension      = $name[1];

        if(in_array($onlyExtension, $allowedExtension))
        {
            $size = getimagesize($this->path.'/'.$folder.'/'.$fileName);
            if($size[0] > 800)
            {
                $image = \Config\Services::image();
                $image->withFile($this->path.'/'.$folder.'/'.$fileName)
                    ->resize(800, 800, true, 'width')
                    ->save($this->path.'/'.$folder.'/'.$onlyName.'_min.'.$onlyExtension);
                $url = $this->url.'/'.$folder.'/'.$onlyName.'_min.'.$onlyExtension;
            }
            else
            {
                $url = $this->url.'/'.$folder.'/'.$fileName;
            }
            $message = '';
        }
        else
        {
            //document type
            $url        = $this->url.'/'.$folder.'/'.$fileName;
            $message    = '';
        }
        //output script to tell CKEditor
        echo '<script>';
        echo 'window.parent.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.', "'.$url.'", "'.$message.'")';
        echo '</script>';
    }
}