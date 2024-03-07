<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Lokasi extends ResourceController
{
    protected $modelName = 'App\Models\LokasiModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->where('is_deleted', 0)->findAll() ?? []);
    }

    public function create()
    {
        $data = $this->request->getPost();
        return $this->respond($this->model->insert($data));
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        return $this->respond($this->model->save($data));
    }
    
    public function delete($id = null)
    {
        return $this->respond($this->model->save(['id' => $id, 'is_deleted' => 1]));
    }
}
