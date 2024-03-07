<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Relocation extends BaseController
{
    public function index()
    {
        return view('layout/relocation/index');
    }
}
