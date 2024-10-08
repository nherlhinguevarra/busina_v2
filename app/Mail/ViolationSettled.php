<?php

namespace App\Mail;

use App\Models\Violation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ViolationSettled extends Mailable
{
    use Queueable, SerializesModels;

    public $violation;

    public function __construct(Violation $violation)
    {
        $this->violation = $violation;
    }

    public function build()
    {
        return $this->subject('Violation Settled')
                    ->view('violation_settled_email'); // create this view for email content
    }
}

