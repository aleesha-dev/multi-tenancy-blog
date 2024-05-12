<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
Broadcast::channel('users.created', function ($user) {
    return true;
});

Broadcast::channel('blogs.created', function ($user) {
    return true;
});
