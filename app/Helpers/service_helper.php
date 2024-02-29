<?php

use Google\Cloud\Storage\StorageClient;

function unapproveServiceCount($db)
{
    $builder = $db->table('service');
    $builder->selectCount('ID');
    $builder->where('status', '0');
    $result = $builder->get()->getRow();
    return $result->ID;
}

function coba($gambar)
{
    // Set the bucket name in GCS
    $bucketName = 'dikpora';

    // Specify the object (file) name in GCS
    $objectName = $gambar;

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
