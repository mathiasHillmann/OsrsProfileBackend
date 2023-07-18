<?php

declare(strict_types=1);

namespace App\Enums;

enum AchievementDiaryTier: string
{
    case Easy = 'easy';
    case Medium = 'medium';
    case Hard = 'hard';
    case Elite = 'elite';
}
