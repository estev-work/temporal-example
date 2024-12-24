<?php

declare(strict_types=1);

namespace Modules\Idea\Application\Workflow\Activity\CheckPayment;

use Temporal\Activity\ActivityInterface;
use Temporal\Activity\ActivityMethod;

#[ActivityInterface]
interface CheckPaymentActivityInterface
{
    #[ActivityMethod(name: 'Проверка оплаты идеи')]
    public function run(string $ideaSerializable): string;
}
