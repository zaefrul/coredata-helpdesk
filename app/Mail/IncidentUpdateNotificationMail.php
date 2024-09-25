<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncidentUpdateNotificationMail extends Mailable implements ShouldQueue
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
        return $this->view('emails.incident_update_notification')
                    ->subject($this->incident->incident_number . ': Incident Update Notification')
                    ->with([
                        'incident' => $this->incident,
                        'user' => $this->user,
                    ]);
    }
}
