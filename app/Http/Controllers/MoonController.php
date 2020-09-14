<?php

namespace App\Http\Controllers;

use App\Models\Moon;
use Illuminate\Http\Request;

class MoonController extends Controller
{
    public function create(Request $request)
    {
        return Moon::create([
            "ip" => $request->getClientIp(),
            "name" => $request->moon,
        ]);
    }

    public function  index(Request $request)
    {
        $moon = Moon::where("name", $request->moon)->first();
        return $moon->moonHistory;
    }
}
