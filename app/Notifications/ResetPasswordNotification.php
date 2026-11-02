<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification {

    public $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        $resetUrl = url('/reset/' . $this->token . '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject('HMS Portal — Password Reset Request')
            ->view('emails.reset_password', [
                'resetUrl' => $resetUrl,
                'userName' => $notifiable->name,
            ]);
    }
}