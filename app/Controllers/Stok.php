<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Stok extends BaseController
{
    public function index()
    {
        return view('layout/stok/index');
    }
}
