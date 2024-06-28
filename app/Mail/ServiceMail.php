<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build(): ServiceMail
    {
        $email = $this->subject($this->details['subject'])
            ->to($this->details['to'])
            ->view('api.V1.Inspections.Reports.inspection_email');
        // Si hay un archivo para adjuntar, lo añadimos al correo.
        if (isset($this->details['attachment'])) {
            $email->attach(public_path($this->details['attachment']));
        }

        return $email;
    }
}
