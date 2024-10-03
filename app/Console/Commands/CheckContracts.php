<?php

namespace App\Console\Commands;

use App\Mail\ContractEndNotificationMail;
use App\Models\Contract;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckContracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:check-end-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check contracts nearing their end dates and send notifications to admins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $threeMonthsFromNow = $now->copy()->addMonths(3);

        $this->info('Scheduled task : ' . $this->signature . " started at " . $now);

        $contracts = Contract::where('end_date', '>=', $now)
            ->where('end_date', '<=', $threeMonthsFromNow)
            ->get();

        if($contracts->count() > 0) {
            Log::debug('Found ' . $contracts->count() . ' contracts ending soon');

            $contractEndNotificationMail = Setting::where('field', 'contract_end_notification_mail')->first();
            $emailsTo = [];

            if($contractEndNotificationMail->count() > 0) {
                $emailsTo = explode(',', $contractEndNotificationMail->value);
            }
            else {
                $admins = User::where('role', 'admin')->pluck('email')->toArray();
                $emailsTo = $admins;
            }

            Mail::to($emailsTo)->send(new ContractEndNotificationMail($contracts));
        }

        $this->info('Scheduled task : ' . $this->signature . " ended at " . Carbon::now());
    }
}
