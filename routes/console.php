<?php

use App\Console\Commands\PMReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('pm:pm-reminder', PMReminder::class)
    ->purpose('Remind agents of PM tasks that are due in 30, 15, and 7 days')
    ->daily()
    ->appendOutputTo(storage_path('logs/pm-reminder.log'));

Schedule::command('contracts:check-end-dates')
    ->daily()
    ->appendOutputTo(storage_path('logs/contracts.log'));

Schedule::command('pm:pm-reminder')
    ->daily()
    ->appendOutputTo(storage_path('logs/pm-reminder.log'));