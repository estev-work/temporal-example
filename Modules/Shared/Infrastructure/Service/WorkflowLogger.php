<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Service;

use Illuminate\Log\Logger;
use Illuminate\Log\LogManager;
use Modules\Shared\Application\WorkflowLoggerInterface;

final class WorkflowLogger extends Logger implements WorkflowLoggerInterface
{
    public function __construct()
    {
        $logManager = app(LogManager::class);
        parent::__construct($logManager->channel('workflow'));
    }
}
