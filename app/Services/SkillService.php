<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class SkillService implements TranslatingInterface
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

    public function translate(array &$data): void
    {
        $skills = $this->getValuesToTrack();

        foreach ($skills as $skillName => $skill) {
            $item = $data[$skillName];
            if (!$item) {
                $data['skills'][$skillName] = [
                    'realLevel' => null,
                    'virtualLevel' => null,
                    'experience' => 0,
                ];
            }

            $data['skills'][$skillName] = [
                'realLevel' => $this->experienceToLevel($item['value']),
                'virtualLevel' => $this->experienceToLevel($item['value'], true),
                'experience' => $item['value'],
            ];

            unset($data[$skillName]);
        }
    }

    private function experienceToLevel(int $experience, bool $virtual = false): int
    {
        // Xp of the next level - 1
        $level = match (true) {
            $experience <= 82 => 1,
            $experience <= 173 => 2,
            $experience <= 275 => 3,
            $experience <= 387 => 4,
            $experience <= 511 => 5,
            $experience <= 649 => 6,
            $experience <= 800 => 7,
            $experience <= 968 => 8,
            $experience <= 1153 => 9,
            $experience <= 1357 => 10,
            $experience <= 1583 => 11,
            $experience <= 1832 => 12,
            $experience <= 2106 => 13,
            $experience <= 2410 => 14,
            $experience <= 2745 => 15,
            $experience <= 3114 => 16,
            $experience <= 3522 => 17,
            $experience <= 3972 => 18,
            $experience <= 4469 => 19,
            $experience <= 5017 => 20,
            $experience <= 5623 => 21,
            $experience <= 6290 => 22,
            $experience <= 7027 => 23,
            $experience <= 7841 => 24,
            $experience <= 8739 => 25,
            $experience <= 9729 => 26,
            $experience <= 10823 => 27,
            $experience <= 12030 => 28,
            $experience <= 13362 => 29,
            $experience <= 14832 => 30,
            $experience <= 16455 => 31,
            $experience <= 18246 => 32,
            $experience <= 20223 => 33,
            $experience <= 22405 => 34,
            $experience <= 24814 => 35,
            $experience <= 27472 => 36,
            $experience <= 30407 => 37,
            $experience <= 33647 => 38,
            $experience <= 37223 => 39,
            $experience <= 41170 => 40,
            $experience <= 45528 => 41,
            $experience <= 50338 => 42,
            $experience <= 55648 => 43,
            $experience <= 61511 => 44,
            $experience <= 67982 => 45,
            $experience <= 75126 => 46,
            $experience <= 83013 => 47,
            $experience <= 91720 => 48,
            $experience <= 101332 => 49,
            $experience <= 111944 => 50,
            $experience <= 123659 => 51,
            $experience <= 136593 => 52,
            $experience <= 150871 => 53,
            $experience <= 166355 => 54,
            $experience <= 184039 => 55,
            $experience <= 203253 => 56,
            $experience <= 224465 => 57,
            $experience <= 247885 => 58,
            $experience <= 273741 => 59,
            $experience <= 302287 => 60,
            $experience <= 333803 => 61,
            $experience <= 368598 => 62,
            $experience <= 407014 => 63,
            $experience <= 449427 => 64,
            $experience <= 496253 => 65,
            $experience <= 547952 => 66,
            $experience <= 605031 => 67,
            $experience <= 668050 => 68,
            $experience <= 737626 => 69,
            $experience <= 841444 => 70,
            $experience <= 899256 => 71,
            $experience <= 992864 => 72,
            $experience <= 1096277 => 73,
            $experience <= 1210420 => 74,
            $experience <= 1336442 => 75,
            $experience <= 1475580 => 76,
            $experience <= 1629199 => 77,
            $experience <= 1798807 => 78,
            $experience <= 1986067 => 79,
            $experience <= 2192817 => 80,
            $experience <= 2421086 => 81,
            $experience <= 2673113 => 82,
            $experience <= 2951372 => 83,
            $experience <= 3258593 => 84,
            $experience <= 3597791 => 85,
            $experience <= 3972293 => 86,
            $experience <= 4385775 => 87,
            $experience <= 4842294 => 88,
            $experience <= 5346331 => 89,
            $experience <= 5902830 => 90,
            $experience <= 6517252 => 91,
            $experience <= 7195628 => 92,
            $experience <= 7944613 => 93,
            $experience <= 8771557 => 94,
            $experience <= 9684576 => 95,
            $experience <= 10692628 => 96,
            $experience <= 11805605 => 97,
            $experience <= 13034430 => 98,
            $experience <= 14391159 => 99,
            $experience <= 15889108 => 100,
            $experience <= 17542975 => 101,
            $experience <= 19368991 => 102,
            $experience <= 21385072 => 103,
            $experience <= 23611005 => 104,
            $experience <= 26068631 => 105,
            $experience <= 28782068 => 106,
            $experience <= 31777942 => 107,
            $experience <= 35085653 => 108,
            $experience <= 38737660 => 109,
            $experience <= 42769800 => 110,
            $experience <= 47221640 => 111,
            $experience <= 52136868 => 112,
            $experience <= 57563717 => 113,
            $experience <= 63555442 => 114,
            $experience <= 70170839 => 115,
            $experience <= 77474827 => 116,
            $experience <= 85539081 => 117,
            $experience <= 94442736 => 118,
            $experience <= 104273166 => 119,
            $experience <= 115126837 => 120,
            $experience <= 127110259 => 121,
            $experience <= 140341027 => 122,
            $experience <= 154948976 => 123,
            $experience <= 171077456 => 124,
            $experience <= 188884739 => 125,
            default => 126,
        };

        if (!$virtual && $level > 99) {
            $level = 99;
        }

        return $level;
    }

    private function makeObject(string $index, RunescapeTypes $type): array
    {
        return [
            'index' => $index,
            'type' => $type,
        ];
    }
}
