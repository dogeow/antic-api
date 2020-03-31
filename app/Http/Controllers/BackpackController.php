<?php

namespace App\Http\Controllers;

use App\Models\Backpack;
use Illuminate\Http\Request;

class BackpackController extends Controller
{
    public function index()
    {
        $user = $this->auth->user();

        return Backpack::where('user_id', $user['id'])->get();
    }
}
