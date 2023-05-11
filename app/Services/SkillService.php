<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class SkillService
{
    public function getValuesToTrack(): array
    {
        return [
            'agility' => $this->makeObject('AGILITY', RunescapeTypes::Skill),
            'attack' => $this->makeObject('ATTACK', RunescapeTypes::Skill),
            'construction' => $this->makeObject('CONSTRUCTION', RunescapeTypes::Skill),
            'cooking' => $this->makeObject('COOKING', RunescapeTypes::Skill),
            'crafting' => $this->makeObject('CRAFTING', RunescapeTypes::Skill),
            'defence' => $this->makeObject('DEFENCE', RunescapeTypes::Skill),
            'farming' => $this->makeObject('FARMING', RunescapeTypes::Skill),
            'firemaking' => $this->makeObject('FIREMAKING', RunescapeTypes::Skill),
            'fishing' => $this->makeObject('FISHING', RunescapeTypes::Skill),
            'fletching' => $this->makeObject('FLETCHING', RunescapeTypes::Skill),
            'herblore' => $this->makeObject('HERBLORE', RunescapeTypes::Skill),
            'hitpoints' => $this->makeObject('HITPOINTS', RunescapeTypes::Skill),
            'hunter' => $this->makeObject('HUNTER', RunescapeTypes::Skill),
            'magic' => $this->makeObject('MAGIC', RunescapeTypes::Skill),
            'mining' => $this->makeObject('MINING', RunescapeTypes::Skill),
            'prayer' => $this->makeObject('PRAYER', RunescapeTypes::Skill),
            'ranged' => $this->makeObject('RANGED', RunescapeTypes::Skill),
            'runecraft' => $this->makeObject('RUNECRAFT', RunescapeTypes::Skill),
            'slayer' => $this->makeObject('SLAYER', RunescapeTypes::Skill),
            'smithing' => $this->makeObject('SMITHING', RunescapeTypes::Skill),
            'strength' => $this->makeObject('STRENGTH', RunescapeTypes::Skill),
            'thieving' => $this->makeObject('THIEVING', RunescapeTypes::Skill),
            'woodcutting' => $this->makeObject('WOODCUTTING', RunescapeTypes::Skill),
        ];
    }

    private function makeObject(string $index, RunescapeTypes $type): array
    {
        return [
            'index' => $index,
            'type' => $type->value,
        ];
    }
}
