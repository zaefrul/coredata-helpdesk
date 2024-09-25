<?php

namespace App\Mail;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractEndNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contracts;

    public function __construct($contracts)
    {
        $this->contracts = $contracts;
    }

    public function build()
    {
        return $this->view('emails.contract_end_notification')
                    ->subject('Contract Ending Soon')
                    ->with([
                        'contracts' => $this->contracts,
                    ]);
    }
}
