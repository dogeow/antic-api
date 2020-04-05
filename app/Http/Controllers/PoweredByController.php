<?php

namespace App\Http\Controllers;

use App\Models\PoweredBy;
use Illuminate\Http\Request;

class PoweredByController extends Controller
{
    public function index()
    {
        return PoweredBy::jsonPaginate(request('size'));
    }
}
