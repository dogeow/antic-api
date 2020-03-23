<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
