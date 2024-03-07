<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BarangKeluar extends BaseController
{
    public function index()
    {
        return view('layout/barang-keluar/index');
    }

    public function form()
    {
        return view('layout/barang-keluar/form');
    }
}