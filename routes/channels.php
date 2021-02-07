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
    \Log::info($user->id);
    \Log::info($id);
    return (int) $user->id === (int) $id;
});


/*
 ** Broadcast Presence Channel Online
 *
 */
Broadcast::channel('online',function ($user){
    return $user;
});

/*
 ** Broadcast Chat Event Channel
 */
Broadcast::channel('chat.{thread_id}', function ($user,$thread_id) {
     \Log::info($user);
     \Log::info($thread_id);
     return $user;

});
