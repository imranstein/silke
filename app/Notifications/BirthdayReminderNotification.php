<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BirthdayReminderNotification extends Notification
{
    use Queueable;

    public $name;
    public $date;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $date)
    {
        $this->name = $name;
        $this->date = $date;
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
            //   reminder that the birthday of $this->name is on $this->date
            ->subject('Birthday Reminder')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('reminder that the birthday of ' . $this->name . ' is on ' . $this->date);
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
            'data' => 'reminder that the birthday of ' . $this->name . ' is on ' . $this->date,
            'id' => $notifiable->id,
        ];
    }
}
