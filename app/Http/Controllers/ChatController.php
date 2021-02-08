<?php

namespace App\Http\Controllers;

use App\Events\TestBroadcastingEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function message(Request $request): void
    {
        broadcast(new TestBroadcastingEvent($request->message));
    }
}
