<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('chat', function ($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email ?? '',
        'active' => true,
    ];
});

Broadcast::channel('game', function ($user) {
    $userData = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email ?? '',
    ];
    $gameData = Cache::get("game.{$user->id}");

    return array_merge($userData, $gameData);
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
