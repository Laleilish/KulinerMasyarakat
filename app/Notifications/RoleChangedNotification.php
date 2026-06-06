<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RoleChangedNotification extends Notification
{
    use Queueable;

    public $newRole;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $newRole)
    {
        $this->newRole = $newRole;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $message = $this->newRole === 'admin'
            ? 'Anda Telah Menjadi Admin.'
            : 'Status Admin pada akun Anda Telah Dicabut.';

        return [
            'message' => $message,
            'url' => url('/'),
        ];
    }
}
