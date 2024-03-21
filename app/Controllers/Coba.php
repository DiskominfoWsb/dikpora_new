<?php

namespace App\Controllers;

class Coba extends BaseController
{
    public function index()
    {
        echo password_hash('password', PASSWORD_BCRYPT, ['cost' => 11]);
    }
}
