<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $user = $this->auth->user();
        $exps = config('experience');

        return array_merge($user->toArray(), ['nextLevelNeedExp' => $exps[$user['level'] + 1]]);
    }
}
