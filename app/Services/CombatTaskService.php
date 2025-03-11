<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;
use Illuminate\Support\Facades\File;

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
        $vars = File::json(base_path('data/combat-achievements-vars.json'));

        $varsToTrack = [];

        for ($i = 0; $i < count($vars); ++$i) {
            $index = $i + 1;

            $varsToTrack["combat_achivement_{$index}"] = [
                'index' => $vars[$i],
                'type' => RunescapeTypes::VarPlayer,
            ];
        }

        return $varsToTrack;
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
