<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $incident;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($incident, $user)
    {
        $this->incident = $incident;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.incident_notification')
                    ->subject('New Incident Notification')
                    ->with([
                        'incident' => $this->incident,
                        'user' => $this->user,
                    ]);
    }
}
