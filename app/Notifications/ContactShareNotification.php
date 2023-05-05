<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactShareNotification extends Notification
{
    use Queueable;

    public $name;
    public $phone;
    public $from;
    public $id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from, $name, $phone, $id)
    {
        $this->from = $from;
        $this->name = $name;
        $this->phone = $phone;
        $this->id = $id;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            ->line('You have received a contact share from ' . $this->from . '.')
            ->line('Name: ' . $this->name)
            ->line('Phone: ' . $this->phone)
            ->action('Accept', url('/acceptContact/' . $this->id));
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
            'data'  => 'You have received a contact share from ' . $this->from . '.', 'Name: ' . $this->name, 'Phone: ' . $this->phone,
            'id' => $this->id,
        ];
    }
}
