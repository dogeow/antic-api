<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = null;
        $topping = null;
        $lastNews = null;

        $now = Carbon::now();
        $hours24Ago = Carbon::now()->subHours(24);
        $user = Auth::user() ?? null;
        $lastReadTime = $user->last_read_time ?? null;

        // 设置已读
        $lastReadTimeViaInput = $request->input('lastReadTime') ?? null;
        if ($lastReadTimeViaInput && $user) {
            $user->last_read_time = $lastReadTimeViaInput;
            $user->update();

            return redirect()->route('index');
        }

        if ($user) {
            if ($lastReadTime) {
                $news = News::where('created_at', '>', $lastReadTime)->orderBy('created_at', 'DESC')->get();
                $topping = Topping::where('created_at', '>', $lastReadTime)->orderBy('created_at', 'DESC')->take(2)->get();
                if ($news->isEmpty()) {
                    // 没有新闻看，显示最后一条新闻的时间
                    $lastNews = News::orderBy('created_at', 'DESC')->first();
                }
            } else {
                // 登录了，但是还没有点击过全部设为已读。
                $news = News::where('created_at', '>', $hours24Ago)->where('created_at', '<=', $now)->orderBy('created_at', 'DESC')->get();
                $topping = Topping::where('created_at', '>', $hours24Ago)->where('created_at', '<=', $now)->orderBy('created_at', 'DESC')->take(2)->get();
            }
        } else {
            // 没有登录的用户
            $news = News::where('created_at', '>', $hours24Ago)->where('created_at', '<=', $now)->orderBy('created_at', 'DESC')->get();
            $topping = Topping::where('created_at', '>', $hours24Ago)->where('created_at', '<=', $now)->orderBy('created_at', 'DESC')->take(2)->get();
        }

        $lastReadTime = $news[0]->created_at ?? $now;

        return
            [
                'news' => $news,
                'topping' => topping($topping),
                'lastReadTime' => $lastReadTime,
                'user' => $user,
                'lastNews' => $lastNews,
            ];
    }
}
