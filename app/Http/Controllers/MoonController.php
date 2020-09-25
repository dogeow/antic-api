<?php

namespace App\Http\Controllers;

use App\Models\Moon;
use Illuminate\Http\Request;

class MoonController extends Controller
{
    public function create(Request $request)
    {
        // 验证格式
        $rules = ['name' => ['required']];
        $validator = \Validator::make(request(['name']), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return Moon::create([
            'ip' => $request->getClientIp(),
            'name' => $request->name,
        ]);
    }

    public function index(Request $request)
    {
        if (! empty($request->name)) {
            $user = Moon::where('name', $request->name)->first();
            $history = $user->moonHistory;
        }

        return [
            'history' => $history ?? [],
            'statistics' => (new Moon)->statistics(),
        ];
    }
}
