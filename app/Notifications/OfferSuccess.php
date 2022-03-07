<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OfferSuccess extends Notification  implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $detail;
    public function __construct($detail)
    {
        $this->detail = $detail;
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
            ->subject('Bid Success')
            ->from('adspot@gmail.com', 'Adspot')
            ->greeting('Hello ' . $this->detail['name'])
            ->line($this->detail['body'])
            ->line('You can proceed to make your payment.')
            ->line('Thank you for using our platform!');
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
            'body' => $this->detail['body'],
            'url' => $this->detail['url']
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => ['body' => $this->data['body'], 'url' => $this->data['url'],],
            'type' => 'newoffer',
            'url' => $this->data['url'],
            'read_at' => null
        ]);
    }
}
