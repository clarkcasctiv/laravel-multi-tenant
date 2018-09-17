<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Password;

class TenantCreated extends Notification
{
    private $hostname;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
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
        $token = Password::broker()->createToken($notifiable);
        $resetUrl = "https://{$this->hostname->fqdn}/password/reset/{$token}";

        $app = config('app.name');

        return (new MailMessage)
                    ->subject('{$app} Invitation')
                    ->greeting('Hello {$notifiable->name},')
                    ->line('You have been invited to use {$app}!')
                    ->line('To get started you need to set a password.')
                    ->action('Set Password', $resetUrl);
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
