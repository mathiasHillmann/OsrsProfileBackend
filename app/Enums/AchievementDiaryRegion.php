<?php

declare(strict_types=1);

namespace App\Enums;

enum AchievementDiaryRegion: string
{
    case Ardougne = 'ardougne';
    case Desert = 'desert';
    case Falador = 'falador';
    case Fremennik = 'fremennik';
    case Kandarin = 'kandarin';
    case Karamja = 'karamja';
    case Kourend = 'kourend';
    case Lumbridge = 'lumbridge';
    case Morytania = 'morytania';
    case Varrock = 'varrock';
    case Western = 'western';
    case Wilderness = 'wilderness';
}
