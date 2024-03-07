<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

use Exception;
use ReflectionException;

class Stok extends ResourceController
{
    protected $modelName = 'App\Models\ArusStokModel';
    protected $format = 'json';
    
    public function index()
    {
        return $this->respond($this->model->getArusStok()->getResult());
    }

    public function show($id = null, $faktur = null, $tanggal = null)
    {
        $out = $this->request->getGet('out') ?? false;
        if(!$out){
            $data = $this->model->getInStok($id,$faktur,$tanggal)->getResult();
        }else{
            $data = $this->model->getOutStok($id,$faktur,$tanggal)->getResult();
        }
        return $this->respond($data ?? [], 200);
    }
}
