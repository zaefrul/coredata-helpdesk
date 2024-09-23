<?php

namespace App\Services;

use App\Helper\SettingHelper;
use App\Mail\IncidentNotificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send incident notification email.
     *
     * @param $incident
     * @param $recipients (array or string)
     * @param $cc (optional array)
     * @param $bcc (optional array)
     * @return void
     */
    public static function sendIncidentNotification($incident, $recipients, $cc = [], $bcc = [])
    {
        try {
            $emailServiceOn = SettingHelper::getValue('email_service', 'switch');

            if(!$emailServiceOn || $emailServiceOn == 'off') {
                Log::debug('Email service is disabled');
                return;
            }

            Log::debug('Email service is enabled');

            // remove duplicate emails
            $recipients = array_unique($recipients);

            // Send the email to recipients, handle if it's a string or array
            $mail = Mail::to(is_array($recipients) ? $recipients : [$recipients]);

            // Optional CC emails
            if (!empty($cc)) {
                $mail->cc($cc);
            }

            // Optional BCC emails
            if (!empty($bcc)) {
                $mail->bcc($bcc);
            }

            Log::debug(print_r($recipients, true));
            Log::debug(print_r($cc, true));
            

            // Send the email
            $mail->send(new IncidentNotificationMail($incident, $incident->user));
        } catch (\Exception $e) {
            // Log the exception or handle it
            Log::error("Email sending failed: " . $e->getMessage());
        }
    }
}
