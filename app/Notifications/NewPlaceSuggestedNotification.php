<?php

namespace App\Notifications;

use App\Models\SubmitPlace;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPlaceSuggestedNotification extends Notification
{
    use Queueable;

    public $submitPlace;

    /**
     * Create a new notification instance.
     */
    public function __construct(SubmitPlace $submitPlace)
    {
        $this->submitPlace = $submitPlace;
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
        return [
            'message' => 'Ada usulan tempat baru: ' . $this->submitPlace->name,
            'submit_place_id' => $this->submitPlace->id,
            'url' => route('admin.submit-places.show', $this->submitPlace->id),
        ];
    }
}
