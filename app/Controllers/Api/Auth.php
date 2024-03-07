<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    public function create()
    {
        $username = htmlspecialchars($this->request->getPost('username'));
        $password = htmlspecialchars($this->request->getPost('password'));
        $user = $this->model->where('username', $username)->where('password', $password)->get()->getRow();
       
        if($user){
            $session = \Config\Services::session(); 
            $session->set('user', $user);

            return $this->respond("login success", 200);
        }

        return $this->respond("Username atau password salah", 404);
    }
}
