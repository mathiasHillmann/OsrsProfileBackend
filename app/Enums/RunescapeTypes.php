<?php

declare(strict_types=1);

namespace App\Enums;

enum RunescapeTypes: string
{
    case VarPlayer = 'varp';
    case VarBit = 'varb';
    case Skill = 'skill';
    case Killcount = 'killcount';
    case PersonalBest = 'personalbest';
}
