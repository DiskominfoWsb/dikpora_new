<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google\Cloud\Storage\StorageClient;

class View extends Controller
{
    public function viewFile()
    {
        // Set the bucket name in GCS
        $bucketName = 'dikpora';

        // Specify the object (file) name in GCS
        $objectName = $this->request->getGet('view');

        // Initialize the StorageClient
        $storage = new StorageClient([
            'keyFilePath' => ROOTPATH . 'public/service-account-key.json',
            'projectId' => 'diskominfo-wonosobo',
        ]);

        // Get the file URL from GCS
        $bucket = $storage->bucket($bucketName);
        $file = $bucket->object($objectName);

        // Get the public URL of the file
        $fileUrl = $file->signedUrl(time() + 3600); // Valid for 1 hour, adjust as needed

        // Pass the file URL to the view
        return $fileUrl;
    }

    public function downloadFromGCS($bucketName, $objectName, $localFilePath)
    {
        $projectId = 'diskominfo-wonosobo';

        // Create a new Storage client
        $storage = new StorageClient([
            'projectId' => $projectId,
        ]);

        // Specify the GCS bucket and object name
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->object($objectName);

        // Download the file from GCS to a local file
        $object->downloadToFile($localFilePath);

        // Optionally, you can return the local file path or any other information
        return $localFilePath;
    }

    public function download()
    {
        $bucketName = 'dikpora';
        $objectName = $this->request->getGet('file');
        $localFilePath = WRITEPATH . 'downloads/file.txt';

        $result = $this->downloadFromGCS($bucketName, $objectName, $localFilePath);

        if ($result) {
            // File downloaded successfully, you can do further processing here
            echo "File downloaded successfully: $result";
        } else {
            // Error downloading the file
            echo "Error downloading the file from GCS.";
        }
    }
}
