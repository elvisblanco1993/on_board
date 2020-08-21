<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.invite-email')
            ->subject('Create your ' . config('app.name') . ' account.');
    }
}
