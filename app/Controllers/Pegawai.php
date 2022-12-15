<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPegawai;

class Pegawai extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelPegawai();
    }

    public function index()
    {
        $data = $this->model->orderBy('nama','asc')->findAll();
        return $this->respond($data,200);
    }

    // menthod show = get
    public function show($nama = null)
    {
        $data = $this->model->where('nama' , $nama)->findAll();

        if ($data) {
            return $this->respond($data, 200);
        }else {
            return $this->failNotFound("Data tidak ditemukan untuk nama $nama");
        }
    }

    // menthod create = post
    public function create()
    {
        // $data = [
        //     'nama' => $this->request->getVar('nama'),
        //     'email' => $this->request->getVar('email')
        // ];
        $data = $this->request->getPost();
        
        // $this->model->save($data);
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil memasukan data pegawai'
            ]   
        ];
        return $this->respond($response);
    }

    // menthod update = put
    public function update( $id = null)
    {

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $isExists = $this->model->where('id',$id )->findAll();

        if (!$isExists) {
            return $this->failNotFound("Data tidak ditemukan dengan id $id");
        }

        // kalau data yg diinputkan user tidak benar
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => "Data Pegawai dengan id $id berhasil di update"
            ]   
        ];
        return $this->respond($response);
    }

    // menthod delete
    public function delete($id = null)
    {
        $data = $this->model->where('id',$id)->findAll();
        if ($data) {
            $this->model->delete($id);
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'success' => "Data berhasil di delete"
                ]   
            ];
            return $this->respondDeleted($response);
        }else {
            return $this->failNotFound("Data tidak ditemukan dengan id $id");
        }
    }
}
