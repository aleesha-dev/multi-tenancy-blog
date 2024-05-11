<?php

namespace App\Listeners\Tenants;

use App\Events\Tenants\UserCreated as TenantsUserCreated;
use App\Events\UserCreated;
use App\Notifications\Tenants\UserCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyUserCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenantsUserCreated $event): void
    {
        Notification::send(notifiables: $event->user, notification: new UserCreatedNotification($event->user));
        // broadcast(new TenantsUserCreated($event->user));
    }
}
