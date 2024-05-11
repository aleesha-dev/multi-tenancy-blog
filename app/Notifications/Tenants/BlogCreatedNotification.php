<?php

namespace App\Notifications\Tenants;

use App\Models\Tenants\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Tenants\Blog $blog
     */
    public function __construct(protected Blog $blog) {}

    /**
     * Get the delivery channels for the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Blog Post Has Been Created!')
            ->markdown('emails.blog.created', ['blog' => $this->blog]);
    }
}
