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

use App\VideoChat;

Broadcast::channel('VideoChats.{video_chat}', function ($user, VideoChat $video_chat) {
    return $video_chat->users->pluck('id')->contains($user->id);
});
