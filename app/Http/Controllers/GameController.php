<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\GameBroadcastingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function loc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loc' => ['required', 'array'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()])->setStatusCode(202);
        }

        broadcast(new GameBroadcastingEvent($request->loc))->toOthers();
    }
}
