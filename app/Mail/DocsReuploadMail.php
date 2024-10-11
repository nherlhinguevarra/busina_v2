<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocsReuploadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filesToReupload;
    public $user;

    public function __construct($filesToReupload, $user)
    {
        $this->filesToReupload = $filesToReupload;
        $this->user = $user;

    }

    public function build()
    {
        return $this->subject('Reupload Required Documents')
                    ->view('reupload_docs_mail')
                    ->with([
                        'filesToReupload' => $this->filesToReupload,
                        'user' => $this->user, // Pass the user data to the view
                    ]);
    }
}
