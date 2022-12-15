<?php

namespace App\Models;
use CodeIgniter\Model;
class ModelPegawai extends Model

{
    protected $table = "pegawai";
    protected $primayKey = "id";
    protected $allowedFields = ['nama','email'];

    // membuat rules untuk method post
    protected $validationRules = [
        'nama' => 'required',
        'email' => 'required|valid_email'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Silahkan masukan nama'
        ],
        'email' => [
            'required' => 'Silahkan masukan email',
            'valid_email' => 'Email yang dimasukan tidak valid'
        ]
    ];
}
