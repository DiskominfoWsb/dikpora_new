<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google\Cloud\Storage\StorageClient;

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

    // Modify this function to upload files to Google Cloud Storage
    protected function general($field = 'upload', $folder = 'upload/img')
    {
        // Get file from request
        $file = $this->request->getFile($field);

        // Check if file is valid
        if ($file->isValid() && !$file->hasMoved()) {
            // Upload to GCS
            $fileName = $this->uploadToGCS($file, $folder);

            return $fileName;
        } else {
            return null;
        }
    }

    // Upload file to Google Cloud Storage and delete local copy
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


    // Modify this function to handle file uploads from CKEditor
    public function imageFileEditor($field = 'upload')
    {
        // Get CKEditor function number
        $CKEditorFuncNum = $this->request->getGet('CKEditorFuncNum');

        // Upload file to GCS
        $filePath = $this->general($field);

        // Construct the URL for the uploaded file
        $url = site_url('upload/view?file=' . $filePath);

        // Output script to tell CKEditor
        echo '<script>';
        echo 'window.parent.CKEDITOR.tools.callFunction(' . $CKEditorFuncNum . ', "' . $url . '", "")';
        echo '</script>';
    }

    public function view()
    {
        // Get the file path from the request
        $filePath = $this->request->getVar('file');

        // Set the bucket name in GCS
        $bucketName = 'dikpora';

        // Initialize the StorageClient
        $storage = new StorageClient([
            'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
            'projectId' => 'diskominfo-wonosobo',
        ]);

        // Get the file URL from GCS
        $bucket = $storage->bucket($bucketName);
        $file = $bucket->object($filePath);

        // Check if the file exists in GCS
        if ($file->exists()) {
            // Set the appropriate headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');

            // Stream the file directly from GCS to the client
            echo $file->downloadAsStream();

            // Terminate the script after sending the file
            exit;
        } else {
            // File not found, return an error
            return $this->response->setStatusCode(404)->setBody('File not found');
        }
    }
}
