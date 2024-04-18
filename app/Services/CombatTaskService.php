<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class CombatTaskService implements OsrsService
{
    public function translate(array $data): array
    {
        $achieviements = $this->getValuesToTrack();
        $return = [];

        $tasks = \File::json(base_path('data/combat-achievements-tasks.json'));

        $index = 0;

        foreach ($achieviements as $CATag => $achievement) {
            for ($i = 0; $i < 32; ++$i) {
                $completed = null;

                if (array_key_exists($CATag, $data)) {
                    $completed = $this->isBitSet((string) $data[$CATag], $i);
                }

                $task = $tasks[32 * $index + $i] ?? null;

                if ($task) {
                    $return[] = [
                        ...$task,
                        'completed' => $completed,
                    ];
                }
            }

            ++$index;
        }

        usort($return, fn ($a, $b) => strcmp($a['monster'], $b['monster']));

        return $return;
    }

    public function getValuesToTrack(): array
    {
        return [
            'combat_achivement_1' => $this->makeObject(
                3116,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_2' => $this->makeObject(
                3117,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_3' => $this->makeObject(
                3118,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_4' => $this->makeObject(
                3119,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_5' => $this->makeObject(
                3120,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_6' => $this->makeObject(
                3121,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_7' => $this->makeObject(
                3122,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_8' => $this->makeObject(
                3123,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_9' => $this->makeObject(
                3124,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_10' => $this->makeObject(
                3125,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_11' => $this->makeObject(
                3126,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_12' => $this->makeObject(
                3127,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_13' => $this->makeObject(
                3128,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_14' => $this->makeObject(
                3387,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_15' => $this->makeObject(
                3718,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_16' => $this->makeObject(
                3773,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_17' => $this->makeObject(
                3774,
                RunescapeTypes::VarPlayer,
            ),
            'combat_achivement_18' => $this->makeObject(
                4204,
                RunescapeTypes::VarPlayer,
            ),
        ];
    }

    private function makeObject(
        int $index,
        RunescapeTypes $type,
    ): array {
        return [
            'index' => $index,
            'type' => $type,
        ];
    }

    private function isBitSet(string $bitmap, int $index): ?bool
    {
        if ($bitmap) {
            return (bool) ($bitmap & (1 << $index));
        } else {
            return null;
        }
    }
}
