<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
