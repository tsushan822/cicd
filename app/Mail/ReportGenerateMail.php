<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportGenerateMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    private $archiveFile;

    /**
     * Create a new message instance.
     * @param $archiveFile
     */
    public function __construct($archiveFile)
    {
        $this -> archiveFile = $archiveFile;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this -> markdown('emails.report.generator')
            -> attach($this -> archiveFile, [
                'mime' => 'application/zip',
            ]);
    }
}
