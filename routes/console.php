<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$schedule->command('reservation:auto-cancel')->dailyAt('19:00'); // 7 PM
$schedule->command('billing:no-show')->dailyAt('19:00'); // 7 PM
