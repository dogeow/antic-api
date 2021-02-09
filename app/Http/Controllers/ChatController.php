<?php

namespace App\Http\Controllers;

use App\Events\TestBroadcastingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()])->setStatusCode(202);
        }

        broadcast(new TestBroadcastingEvent($request->message))->toOthers();
    }
}
