<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestBroadcastingEvent;

class ChatController extends Controller
{
    public function message(Request $request): void
    {
        broadcast(new TestBroadcastingEvent($request->message));
    }
}
