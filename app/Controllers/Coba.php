<?php

namespace App\Controllers;

use Google\Cloud\Storage\StorageClient;

class Coba extends BaseController
{
    public function index()
    {
        // echo password_hash('password', PASSWORD_BCRYPT, ['cost' => 11]);
        // Konfigurasi Google Cloud
        $projectId = 'diskominfo-wonosobo';
        $keyFilePath =  ROOTPATH . 'public/service-account-key.json';
        $bucketName = 'dikpora';

        // Inisialisasi Google Cloud Storage client
        $storage = new StorageClient([
            'projectId' => $projectId,
            'keyFilePath' => $keyFilePath
        ]);

        // Dapatkan objek bucket
        $bucket = $storage->bucket($bucketName);

        // Daftar semua objek dalam bucket
        $objects = $bucket->objects();

        // Siapkan daftar gambar
        $images = [];
        foreach ($objects as $object) {
            $extension = pathinfo($object->name(), PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $images[] = [
                    'name' => $object->name()
                ];
            }
        }

        // Tampilkan view dengan daftar gambar
        return view('images', ['images' => $images]);
    }
}
