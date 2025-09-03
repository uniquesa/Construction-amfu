<?php

namespace App\Notifications;

use App\Models\RequestEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestSubmitted extends Notification
{
    use Queueable;

    public $requestEntry;

    public function __construct(RequestEntry $requestEntry)
    {
        $this->requestEntry = $requestEntry;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // in-app + email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Request Submitted')
            ->line('A new request has been submitted.')
            ->action('View Request', url('/requests/'.$this->requestEntry->id));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Request #'.$this->requestEntry->id.' submitted',
            'request_id' => $this->requestEntry->id,
        ];
    }
}
