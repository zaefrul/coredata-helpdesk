<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PMReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $incident;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($incident, $user)
    {
        $this->incident = $incident;
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.pm_notification')
                    ->subject($this->incident->incident_number . ': Preventive Maintenance Task Reminder')
                    ->with([
                        'incident' => $this->incident,
                        'user' => $this->user,
                    ]);
    }
}
