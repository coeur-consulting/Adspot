<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{id}', function ($user) {
    return  $user;
});


Broadcast::channel('notification', function ($user) {
    return  $user;
});
Broadcast::channel('offer', function ($user) {
    return  $user;
});

