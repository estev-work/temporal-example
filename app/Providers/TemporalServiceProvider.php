<?php

declare(strict_types=1);

namespace App\Providers;

use App\Utils\ActivityRegistrar;
use App\Utils\WorkflowRegistrar;
use Illuminate\Support\ServiceProvider;
use Keepsuit\LaravelTemporal\Facade\Temporal;
use ReflectionException;

class TemporalServiceProvider extends ServiceProvider
{
    /**
     * @throws ReflectionException
     */
    public function register(): void
    {
        $workflows = WorkflowRegistrar::registerWorkflows(
            'Modules\Idea\Application\Workflow',
            base_path('Modules/Idea/Application/Workflow'),
        );
        $activities = ActivityRegistrar::registerActivities(
            'Modules\Idea\Application\Workflow\Activity',
            base_path('Modules/Idea/Application/Workflow/Activity'),
        );
        Temporal::registry()->registerWorkflows(...$workflows)->registerActivities(...$activities);
    }

    public function boot(): void {}
}
