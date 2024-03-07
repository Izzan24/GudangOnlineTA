<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Barang extends BaseController
{
    public function index()
    {
        return view('layout/barang/index');
    }
    
    public function add()
    {
        return view('layout/barang/form');
    }

    public function edit($id)
    {
        return view('layout/barang/form',['id' => $id]);
    }
}
