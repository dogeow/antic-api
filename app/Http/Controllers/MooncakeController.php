<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mooncake;
use App\Models\User;

class MooncakeController extends Controller
{
    public $number;
    public $ip;

    public function __construct(Request $request)
    {
        $this->number = [
            1, 2, 3, 4, 5, 6
        ];
        $this->ip = $request->getClientIp();
    }

    public function index(Request $request){
        $user = User::where('ip', $this->ip)->first();

        return view('welcome')->with(
            [
                'user' => $user,
            ]
        );
    }

    public function go(Request $request)
    {
        $record = true; // 是否署名了

        // 用户信息
        if($request->input('name') ?? null){
            $user = User::updateOrCreate(['ip' => $this->ip], ['name' => $request->input('name')]);
        } else {
            $user = User::firstOrCreate(['ip' => $this->ip], ['name' => $request->input('name')]);
        }

        $mooncakes = $user->mooncakes;

        // 有摇过了
        if ($mooncakes->isEmpty()) {
            $count = 0;
        } else {
            $count = count($mooncakes);
        }

        // 摇骰子
        $numbers = [];
        for ($i = 1; $i <= 6; $i++) {
            $numbers[] = $this->number[array_rand($this->number, 1)];
        }
        $numbers = collect($numbers);


        // 第一次记录，其他不记录
        if ($count < 5) {
            Mooncake::create(
                [
                    'user_id' => $user['id'],
                    'one' => $numbers[0],
                    'two' => $numbers[1],
                    'three' => $numbers[2],
                    'four' => $numbers[3],
                    'five' => $numbers[4],
                    'six' => $numbers[5],
                ]
            );
        }

        return view('welcome')->with(
            [
                'count' => $count,
                'record' => $record,
                'user' => $user,
                'mooncakes' => $mooncakes,
                'numbers' => $numbers ?? null
            ]
        );
    }

    public function submit(Request $request)
    {
        if (empty($request->name)) {
            return view('welcome')->with('error', '请署名');
        }

        $mooncake = Mooncake::where()->first();

        if (is_null($mooncake)) {
            exit;
        }

        print $mooncake['name'];
        if (!empty($mooncake['name'])) {
            $message = '提交成功，请勿重复提交';
        } else {
            $mooncake->name = $request->name;
            if ($mooncake->save()) {
                $message = '提交成功';
            }
        }

        return view('welcome')->with('ok', $message);
    }
}
