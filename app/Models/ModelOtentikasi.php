<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ModelOtentikasi extends Model
{
    protected $table = "otentikasi";
    protected $primayKey = "id";
    protected $allowedFields = ['email','password'];

    // membuat function di untuk file jwt_helper.php
    function getEmail($email)
    {
        $builder = $this->table("otentikasi");
        $data = $builder->where("email",$email)->first();
        if (!$data) {
            throw new Exception("Data otentikasi tidak ditemukan");
        }
        return $data;
    }
}