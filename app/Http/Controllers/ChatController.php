<?php

namespace App\Http\Controllers;

use App\Events\ChatBroadcastingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    // 机器人聊天前缀
    public const ROBOT_PREFIX = '/';

    public function message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()])->setStatusCode(202);
        }

        broadcast(new ChatBroadcastingEvent($request->message))->toOthers();

        // ROBOT_PREFIX 字符转正则格式
        $robotPrefix = preg_quote(self::ROBOT_PREFIX, '/');

        $isAtRobot = preg_match(
            '/^'.$robotPrefix.'(?P<message>.*?)( +(?P<content>.*))?$/',
            (string) $request->message,
            $matches
        );

        // 机器人
        if ($isAtRobot) {
            $content = $matches['content'] ?? null;
            $api = new ApiController();
            $robotMessage = match ($matches['message']) {
                '时间' => date('Y-m-d H:i:s'),
                '单复数' => self::checkParam($content) ?? $api->case($content),
                'md5' => self::checkParam($content) ?? $api->md5($content),
                'ip' => $request->ip(),
                '长度' => self::checkParam($content) ?? mb_strlen((string) $content),
                default => '我暂时还没有加入这个功能。',
            };

            broadcast(new ChatBroadcastingEvent($robotMessage, true));
        }
    }

    /**
     * 检查参数是否漏提供，是的话提示错误，正确则由 ?? 继续返回
     *
     * @param $content
     */
    public static function checkParam($content): null|string
    {
        if ($content === null) {
            return '请键入参数';
        }

        return null;
    }
}
