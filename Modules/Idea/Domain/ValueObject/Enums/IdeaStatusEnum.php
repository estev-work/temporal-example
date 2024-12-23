<?php

namespace Modules\Idea\Domain\ValueObject\Enums;

enum IdeaStatusEnum: string
{
    case NEW = 'new';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CLOSED = 'closed';
}
