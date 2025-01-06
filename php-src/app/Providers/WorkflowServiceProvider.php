<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Idea\Domain\Service\WorkflowLauncherInterface;
use Modules\Idea\Infrastructure\Service\TemporalWorkflowLauncher;

class WorkflowServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WorkflowLauncherInterface::class, TemporalWorkflowLauncher::class);
    }

    public function boot(): void {}
}
