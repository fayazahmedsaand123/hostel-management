<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable {
    use Queueable, SerializesModels;

    public $resetUrl;
    public $userName;

    public function __construct($resetUrl, $userName) {
        $this->resetUrl = $resetUrl;
        $this->userName = $userName;
    }

    public function build() {
        return $this->subject('HMS Portal — Password Reset Request')
                    ->view('emails.reset_password');
    }
}