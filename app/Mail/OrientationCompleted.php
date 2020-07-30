<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrientationCompleted extends Mailable
{
    use Queueable, SerializesModels;
    public $orientationName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $orientationName)
    {
        $this->orientationName = $orientationName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.orientation-completed')
            ->subject('Congratulations on completing ' . $this->orientationName);
    }
}
