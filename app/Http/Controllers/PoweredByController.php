<?php

namespace App\Http\Controllers;

use App\Models\PoweredBy;
use Illuminate\Http\Request;

class PoweredByController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search === null || count($request->search) !== 1) {
            return PoweredBy::jsonPaginate(request('size'));
        }

        foreach ($request->search as $key => $value) {
            if (in_array($key, ['name']) && $value !== '') {
                return PoweredBy::where($key, 'like', '%'.$value.'%')->jsonPaginate(request('size'));
            }
        }
    }
}
