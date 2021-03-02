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

        // 机器人
        if (preg_match('/^ (?P<message>.*?)( (?P<content>.*))?$/', $request->message, $matches)) {
            $robotMessage = '我暂时还没有加入这个功能。';

            $content = $matches['content'];
            $api = new ApiController();
            switch ($matches['message']) {
                case '时间':
                    $robotMessage = date('Y-m-d H:i:s');
                    break;
                case '大小写':
                    $robotMessage = $api->sp($content);
                    break;
                case 'md5':
                    $robotMessage = $api->md5($content);
                    break;
                case 'ip':
                    $robotMessage = $request->ip();
                    break;
                case '长度':
                    $robotMessage = mb_strlen($content);
                    break;
            }

            broadcast(new TestBroadcastingEvent($robotMessage, true));
        }
    }
}
