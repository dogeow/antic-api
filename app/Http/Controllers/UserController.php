<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function password()
    {
        $payload = request(['currPassword', 'newPassword', 'passwordConfirmation']);

        // 验证格式
        $rules = [
            'currPassword' => ['required', 'min:8', 'max:16'],
            'newPassword' => ['required', 'min:8', 'max:16', 'different:currPassword'],
            'passwordConfirmation' => ['same:password'],
        ];
        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $user = auth()->user();
        if ($user->password === bcrypt($payload['currPassword'])) {
            $user->password = bcrypt($payload['password']);
        } else {
            return 401;
        }
    }
}
