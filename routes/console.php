<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('contracts:check-end-dates')
    ->daily()
    ->appendOutputTo(storage_path('logs/contracts.log'));

Schedule::command('app:pm-reminder')
    ->daily()
    ->appendOutputTo(storage_path('logs/pm-reminder.log'));