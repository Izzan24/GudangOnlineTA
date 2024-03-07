<?php

namespace App\Controllers;

class Kategori extends BaseController
{
    public function index()
    {
        return view('layout/kategori/index');
    }

    public function add()
    {
        return view('layout/kategori/form');
    }

    public function edit($id)
    {
        return view('layout/kategori/form',['id' => $id]);
    }
}
