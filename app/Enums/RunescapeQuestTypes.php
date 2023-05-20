<?php

declare(strict_types=1);

namespace App\Enums;

enum RunescapeQuestTypes: string
{
    case Quest = 'quest';
    case Miniquest = 'miniquest';
}
