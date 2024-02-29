<?php

namespace App\Controllers;

use Google\Cloud\Storage\StorageClient;

class Upload extends BaseController
{

    protected $path;
    protected $url;
    protected $name;
    protected $gcsBucketName = 'dikpora';

    public function __construct()
    {
        $this->path = ROOTPATH . 'public/upload';
        $this->url  = base_url('upload');
    }

    protected function general($field = 'upload', $folder = 'img')
    {
        $file = $this->request->getFile($field);

        // Upload to GCS
        $storage = new StorageClient([
            'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
            'projectId' => 'diskominfo-wonosobo',
        ]);
        $bucket = $storage->bucket($this->gcsBucketName);
        $object = $bucket->upload(file_get_contents($file->getPathname()), [
            'name' => $folder . '/' . $this->name,
        ]);

        return $this->name;
    }

    public function imageFileEditor($field = 'upload')
    {
        $allowedExtension   = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoExtension     = ['mp4', 'webm', 'ogv'];
        $CKEditorFuncNum    = $this->request->getGet('CKEditorFuncNum');
        $tempFile           = $this->request->getFile($field);
        $folder             = 'doc';
        if (in_array($tempFile->guessExtension(), $allowedExtension)) $folder = 'img';
        if (in_array($tempFile->guessExtension(), $videoExtension)) $folder = 'vid';
        $fileName           = $this->general($field, $folder);
        $url                = null;
        $message            = 'Failed uploading file!';
        $name               = explode('.', $fileName);
        $onlyName           = $name[0];
        $onlyExtension      = $name[1];

        if (in_array($onlyExtension, $allowedExtension)) {
            $size = getimagesize($this->path . '/' . $folder . '/' . $fileName);
            if ($size[0] > 800) {
                $image = \Config\Services::image();
                $image->withFile($this->path . '/' . $folder . '/' . $fileName)
                    ->resize(800, 800, true, 'width')
                    ->save($this->path . '/' . $folder . '/' . $onlyName . '_min.' . $onlyExtension);

                // Upload resized image to GCS
                $storage = new StorageClient([
                    'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
                    'projectId' => 'diskominfo-wonosobo',
                ]);
                $bucket = $storage->bucket($this->gcsBucketName);
                $resizedObject = $bucket->upload(
                    file_get_contents($this->path . '/' . $folder . '/' . $onlyName . '_min.' . $onlyExtension),
                    ['name' => $folder . '/' . $onlyName . '_min.' . $onlyExtension]
                );
                $url = $this->url . '/' . $folder . '/' . $onlyName . '_min.' . $onlyExtension;
            } else {
                // Upload original image to GCS
                $storage = new StorageClient([
                    'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
                    'projectId' => 'diskominfo-wonosobo',
                ]);
                $bucket = $storage->bucket($this->gcsBucketName);
                $object = $bucket->upload(file_get_contents($this->path . '/' . $folder . '/' . $fileName), [
                    'name' => $folder . '/' . $fileName,
                ]);
                $url = $this->url . '/' . $folder . '/' . $fileName;
            }
            $message = '';
        } else {
            //document type
            $url        = $this->url . '/' . $folder . '/' . $fileName;
            $message    = '';
        }
        //output script to tell CKEditor
        echo '<script>';
        echo 'window.parent.CKEDITOR.tools.callFunction(' . $CKEditorFuncNum . ', "' . $url . '", "' . $message . '")';
        echo '</script>';
    }
}
