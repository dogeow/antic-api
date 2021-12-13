<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\GameBroadcastingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function loc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'x' => ['required', 'int'],
            'y' => ['required', 'int'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()])->setStatusCode(202);
        }

        $user = auth()->user();

        $gameData = $request->only('x', 'y');

        Cache::set("game.{$user->id}", $gameData);

        broadcast(new GameBroadcastingEvent($gameData))->toOthers();
    }
}
