<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BarangMasuk extends BaseController
{
    public function index()
    {
        return view('layout/barang-masuk/index');
    }

    public function form()
    {
        return view('layout/barang-masuk/form');
    }
    
    public function form_2()
    {
        return view('layout/barang-masuk/form-2');
    }

    public function barcode($faktur)
    {
        return view('layout/barang-masuk/print-barcode',['faktur' => $faktur]);
    }
}