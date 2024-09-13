<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'mail:send-test {email}';
    protected $description = 'Send a test email';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $email = $this->argument('email');

        // Send the test email
        Mail::to($email)->send(new TestEmail());

        // Output success message
        $this->info('Test email sent successfully to ' . $email);
    }
}
