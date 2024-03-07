<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';
    
    public function index()
    {
        return $this->respond($this->model->findAll() ?? []);
    }

    public function show($id = null)
    {
        return $this->respond($this->model->where('id', $id)->first());
    }
    
    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return $this->respond("Berhasil menambah data user", 200);
    }
    
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $this->model->save($data);
        return $this->respond("Berhasil mengubah data user", 200);
    }

    public function delete($id = null)
    {
        if($id == 1){
            return $this->respond("Tidak dapat menghapus user ini", 500);
        }
        $this->model->where('id', $id)->delete();
        return $this->respond("Berhasil menghapus data user", 200);
    }
}
