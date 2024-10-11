<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AllDocsApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plateNo;

    public function __construct($user, $plateNo)
    {
        $this->user = $user;
        $this->plateNo = $plateNo;
    }

    public function build()
    {
        return $this->subject('Vehicle Registration Approved')
                    ->view('docs_approved_mail')
                    ->with([
                        'user' => $this->user, // Pass the user data to the view
                        'plateNo' => $this->plateNo, 
                    ]);
    }
}
