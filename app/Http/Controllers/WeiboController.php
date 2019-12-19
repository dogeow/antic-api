<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeiboHot;
use App\Models\WeiboToTop;

class WeiboController extends Controller
{
    public function index($number = null)
    {
        if ($number) {
            $data = WeiboHot::orderBy('updated_at', 'DESC')->take($number)->get();
        } else {
            $data = WeiboHot::all();
        }
        return response()->json($data);
    }
}
