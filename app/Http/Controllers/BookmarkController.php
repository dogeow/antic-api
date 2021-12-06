<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function create(Request $request)
    {
        return \App\Models\Bookmark::create($request->all());
    }
}
