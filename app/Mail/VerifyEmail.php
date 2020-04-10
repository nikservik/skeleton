<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    public $user;
    public $verificationUrl;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->verificationUrl = $this->verificationUrl($this->user);
        
        return $this->subject('Подтверждение вашего email-адреса')
            ->view('emails.verify-email');
    }

    protected function verificationUrl($user)
    {
        return config('app.url').'/email/verify/'
                    .$user->getKey() .'/'
                    .sha1($user->getEmailForVerification());
    }
}
