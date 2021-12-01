<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('user.{user_id}', function ($user, $user_id) {
    return $user->id === \App\Models\User::query()->findOrNew($user_id)->id;
});
Broadcast::channel('ExampleEvent', function ($user, $id) {
    return true;
});

Broadcast::channel('news', function ($user, $id) {
    return true;
});


