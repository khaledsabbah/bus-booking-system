<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected string $password, public string $referrer)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
            ->subject(__('messages.emails.welcome.subject', ['app' => config('app.name')]))
            ->greeting(__('messages.emails.welcome.line1', ['notifiable' => $notifiable->name]))
            ->line(__('messages.emails.welcome.line2', ['app' => config('app.name')]));

        $mailMessage->line(__('messages.emails.welcome.line3_1'));
        $mailMessage->line(__('messages.emails.welcome.line4', ['password' => $this->password]));

        $mailMessage->action(
            __('messages.emails.welcome.action'),
            $this->referrer
        );
        return $mailMessage;
    }
}
