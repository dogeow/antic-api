<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

class SpaController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
