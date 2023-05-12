<?php

declare(strict_types=1);

namespace App\Enums;

enum RunescapeQuestStatus: string
{
    case Complete = 'complete';
    case InProgress = 'in_progress';
    case NotStarted = 'not_started';
}
