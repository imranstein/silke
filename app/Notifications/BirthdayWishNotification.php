<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BirthdayWishNotification extends Notification
{
    use Queueable;

    public $name;
    public $from;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from, $name)
    {
        $this->from = $from;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject($this->from . ' sent you a birthday wish!')
            ->line('Happy Birthday ' . $this->name . '!')
            ->line('We wish you a wonderful birthday and a year full of happiness and joy.')
            ->line('May all your wishes come true!')
            ->line('Best regards,' . $this->from);
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
            //
        ];
    }
}
