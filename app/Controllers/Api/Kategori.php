<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

use Exception;
use ReflectionException;

class Kategori extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format = 'json';
    
    public function index()
    {
        return $this->respond($this->model->where('is_deleted', 0)->findAll());
    }
    
    public function show($id = null)
    {
        return $this->respond($this->model->where('id', $id)->first());
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
