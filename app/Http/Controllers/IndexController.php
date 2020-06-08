<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $project = Project::where('user_id', 1)->first();

        return [
            'todos' => $project ? $project->tasks()->where('is_completed', 0)->get() : [],
            'projects' => Post::with('tags')->with('categories')->get(),
        ];
    }

    public function url()
    {
        return [
            'powered-by' => config('app.url').'/powered-by',
        ];
    }

    protected function untitled(Request $request)
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
                $topping = Topping::where('created_at', '>', $lastReadTime)->orderBy('created_at',
                    'DESC')->take(2)->get();
                if ($news->isEmpty()) {
                    // 没有新闻看，显示最后一条新闻的时间
                    $lastNews = News::orderBy('created_at', 'DESC')->first();
                }
            } else {
                // 登录了，但是还没有点击过全部设为已读。
                $news = News::where('created_at', '>', $hours24Ago)->where('created_at', '<=',
                    $now)->orderBy('created_at', 'DESC')->get();
                $topping = Topping::where('created_at', '>', $hours24Ago)->where('created_at', '<=',
                    $now)->orderBy('created_at', 'DESC')->take(2)->get();
            }
        } else {
            // 没有登录的用户
            $news = News::where('created_at', '>', $hours24Ago)->where('created_at', '<=', $now)->orderBy('created_at',
                'DESC')->get();
            $topping = Topping::where('created_at', '>', $hours24Ago)->where('created_at', '<=',
                $now)->orderBy('created_at', 'DESC')->take(2)->get();
        }

        $lastReadTime = $news[0]->created_at ?? $now;

        $news = $news->reject(function ($item) {
            foreach ([
                         '昆凌', '周杰伦', '郭京飞', '温宇', '湖人', 'J姐', '拜仁', '惠若琪', '巩俐', '黄子韬', '林俊杰', '吴亦凡', '杨幂', 'iG',
                         'SKT', '林更新', 'YM', '范丞丞', '魏大勋', '贾乃亮', 'LGD', 'NIP', '张颜齐', '杨超越',
                     ] as $keyword) {
                if (false !== stripos($item->title, $keyword)) {
                    return true;
                }
            }

            return false;
        });

        return view('welcome', [
            'news' => $news,
            'topping' => topping($topping),
            'lastReadTime' => $lastReadTime, 'user' => $user,
            'lastNews' => $lastNews,
        ]);
    }

    protected function about()
    {
        return view('about');
    }

    protected function test()
    {
        $users = factory('App\Models\User', 10)->make();
        $pages = collect([
            ['name' => 'page1', 'children' => []],
            ['name' => 'page2', 'children' => ['name' => 'page6']],
            ['name' => 'page3', 'children' => []],
            ['name' => 'page4', 'children' => ['name' => 'page7']],
            ['name' => 'page5', 'children' => []],
        ]);

        return view('test')->with(compact('users', 'pages'));
    }
}
