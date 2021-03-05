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
            $content = $matches['content'] ?? null;
            $api = new ApiController();
            $robotMessage = match ($matches['message']) {
                '时间' => date('Y-m-d H:i:s'),
                '大小写' => self::paramIsEmpty($content) ?? $api->sp($content),
                'md5' => self::paramIsEmpty($content) ?? $api->md5($content),
                'ip' => $request->ip(),
                '长度' => self::paramIsEmpty($content) ?? mb_strlen($content),
                default => '我暂时还没有加入这个功能。',
            };

            broadcast(new TestBroadcastingEvent($robotMessage, true));
        }
    }

    /**
     * @param $content
     * @return false|string
     */
    public static function paramIsEmpty($content): bool|string
    {
        if ($content === null) {
            return "请键入参数";
        }

        return false;
    }
}
