<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserConfirmationNotification extends Notification
{
    use Queueable;

    public $isVerified;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($isVerified)
    {
        $this->isVerified = $isVerified;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->markdown('emails.user_confirmation_notify', [
                        'employee' => $notifiable, 
                        'isVerified' => $this->isVerified,
                        'url' => url('vacations/create'),
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'isVerified' => $this->isVerified,
            'type' => 'userConfirmation'
        ];
    }
}
