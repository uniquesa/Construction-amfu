<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestRejected extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
            public function toMail($notifiable)
        {
            return (new MailMessage)
                ->subject('Request Rejected')
                ->line('Your request #'.$this->requestEntry->id.' has been rejected.')
                ->action('View Request', url('/requests/'.$this->requestEntry->id));
        }

        public function toArray($notifiable)
        {
            return [
                'message' => 'Request #'.$this->requestEntry->id.' rejected',
                'request_id' => $this->requestEntry->id,
            ];
        }

}
