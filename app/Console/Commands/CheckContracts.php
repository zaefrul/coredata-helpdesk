<?php

namespace App\Console\Commands;

use App\Mail\ContractEndNotificationMail;
use App\Models\Contract;
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
            $admins = User::where('role', 'admin')->pluck('email')->toArray();

            // remove admin@coredata.com.my
            $admins = array_diff($admins, ['admin@coredata.com.my']);

            Log::debug('Sending notification admins');
            Log::debug(print_r($admins, true));
            Mail::to($admins)->send(new ContractEndNotificationMail($contracts));
        }

        $this->info('Scheduled task : ' . $this->signature . " ended at " . Carbon::now());
    }
}
