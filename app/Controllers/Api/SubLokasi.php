<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class SubLokasi extends ResourceController
{
    protected $modelName = 'App\Models\SubLokasiModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->getLokasiAll()->getResult() ?? []);
    }

    public function show($id = null)
    {
        return $this->respond($this->model->getLokasiById($id)->getRow() ?? []);
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
