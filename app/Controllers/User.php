<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        return view('layout/user/index');
    }

    public function add()
    {
        return view('layout/user/form');
    }

    public function edit($id = '')
    {
        return view('layout/user/form', ['id' => $id]);
    }
}
