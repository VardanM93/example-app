<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductCreateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string $user_name
     * @var string $product_name
     */
    private string  $user_name;
    private string  $product_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $user_name, string $product_name)
    {
        $this->user_name = $user_name;
        $this->product_name = $product_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.product.create',
            [
                'user_name' => $this->user_name,
                'product_name' => $this->product_name
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
