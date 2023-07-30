<?php

declare(strict_types=1);

namespace App\Enums;

enum RunescapeAccountTypes: string
{
    case Normal = 'NORMAL';
    case Ironman = 'IRONMAN';
    case UltimateIronman = 'ULTIMATE_IRONMAN';
    case HardcoreIronman = 'HARDCORE_IRONMAN';
    case GroupIronman = 'GROUP_IRONMAN';
    case HardcoreGroupIronman = 'HARDCORE_GROUP_IRONMAN';
    case UnrankedGroupIronman = 'UNRANKED_GROUP_IRONMAN';
}
