<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $view;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bodyData, $viewName = "welcome", $subject = "Welcome")
    {
        $this->data = $bodyData;
        $this->view = $viewName;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.'.$this->view)->subject($this->subject);
    }
}
