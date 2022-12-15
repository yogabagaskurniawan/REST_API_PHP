<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelOtentikasi;

class Otentikasi extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $validation = \config\Services::validation();
        $aturan = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Silahkan masukan email',
                    'valid_email' => 'Silahkan masukan email yang valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan password',
                ]
            ],
        ];
        $validation->setRules($aturan);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        // sisi user
        // user memasukan data kemudian pengecekan data tersebut
        $model = new ModelOtentikasi();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $model->getEmail($email);
        if ($data['password'] != md5($password)) {
            return $this->fail("password tidak sesuai");
        }

        helper('jwt');
        $response = [
            "message" =>'otentikasi berhasil dilakukan',
            'data' => $data,
            'access_token' => createJWT($email)
        ];
        return $this->respond($response);
    }
}
