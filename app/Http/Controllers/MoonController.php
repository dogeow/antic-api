<?php

namespace App\Http\Controllers;

use App\Models\Moon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoonController extends Controller
{
    public function create(Request $request): Moon | Model
    {
        // 验证格式
        $rules = ['name' => ['required', 'unique:moons']];
        $validator = Validator::make(request(['name']), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        return Moon::create([
            'ip' => $request->getClientIp(),
            'name' => $request->name,
        ]);
    }

    public function index(Request $request): array
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
