<?php

use App\Utils\ActivityRegistrar;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $activities = ActivityRegistrar::registerActivities(
        'Modules\Idea\Application\Workflow\Activity',
        base_path('Modules/Idea/Application/Workflow/Activity'),
    );
    dd($activities);
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
