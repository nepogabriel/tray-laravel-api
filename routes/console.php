<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('sales:process-daily-emails')->dailyAt('18:00');
