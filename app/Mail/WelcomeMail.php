<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

	public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    $address = env('MAIL_FROM_ADDRESS', 'help@wingifts.net');
	    $name = env('MAIL_FROM_NAME', 'Win Gifts');
	    $subject = 'Добро пожаловать';
	    
        return $this->view('emails.registration')
        			->from($address, $name)
        			->subject($subject)
        			->with([ 'password' => $this->data['password'], 'login' => $this->data['login'] ]);
    }
}
