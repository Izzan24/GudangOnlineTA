<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Satuan extends BaseController
{
    public function index()
    {
        return view('layout/satuan/index');
    }

    public function add()
    {
        return view('layout/satuan/form');
    }

    public function edit($id)
    {
        return view('layout/satuan/form',['id' => $id]);
    }
}
