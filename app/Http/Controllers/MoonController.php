<?php

namespace App\Http\Controllers;

use App\Models\Moon;
use App\Models\MoonHistory;
use Illuminate\Http\Request;

class MoonController extends Controller
{
    public function create(Request $request)
    {
        return Moon::create([
            'ip' => $request->getClientIp(),
            'name' => $request->user,
        ]);
    }

    public function index(Request $request)
    {
        if (!empty($request->user)) {
            $user = Moon::where('name', $request->user)->first();
            $history = $user->moonHistory;
        }

        return [
            'history' => $history ?? [],
            'statistics' => (new Moon)->statistics(),
        ];
    }
}
