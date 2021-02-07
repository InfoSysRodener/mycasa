<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
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
        $url = 'http://mycasav2-env.ftppg4fb5f.ap-southeast-1.elasticbeanstalk.com';

        return (new MailMessage)
                    ->subject('Forgot Password')
                    ->greeting('Forgot Password')
                    ->line('You told us you forgot your password. If you really did, click here to create a new one.')
                    ->action('Reset Password', url( $url . '/reset?code='. $this->user->password_reset))
                    ->line('If you didn\'t mean to reset your password, then you can just ignore this email, your password will not change')
                    ->line('Thank you for using our application!')
//                    ->line('MyCasa 2020')
                    ->salutation('MyCasa');
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
