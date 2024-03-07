<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Barang extends ResourceController
{
    protected $modelName = 'App\Models\BarangModel';
    protected $format = 'json';
    
    public function index()
    {
        return $this->respond($this->model->getBarang()->getResult());
    }

    public function show($code = null)
    {
        return $this->respond($this->model->getBarangByCode($code)->getRow() ?? []);
    }
    
    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);
        return $this->respond($data);
    }

    public function update($code = null)
    {
        $data = $this->request->getRawInput();
        $data['code'] = $code;
        return $this->respond($this->model->save($data));
    }
    
    public function delete($code = null)
    {
        return $this->respond($this->model->save(['code' => $code, 'is_deleted' => 1]));
    }
}
