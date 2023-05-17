<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class SummaryService implements TranslatingInterface
{
    public function translate(array &$data, Carbon $updatedAt = null): void
    {
        $data['summary']['total'] = [
            'realLevel' => array_sum(array_column($data['skills'], 'realLevel')),
            'virtualLevel' => array_sum(array_column($data['skills'], 'virtualLevel')),
            'experience' => array_sum(array_column($data['skills'], 'experience')),
        ];

        $data['summary']['combat'] = $this->calculateCombatLevel($data);

        $data['summary']['updatedAt'] = $updatedAt;
    }

    private function calculateCombatLevel(array $data): ?int
    {
        $skills = $data['skills'];

        // Check if skills have been tracked or not based if attack has any value
        if ($skills['attack']['realLevel']) {
            $base = 0.25 * ($skills['defence']['realLevel'] + $skills['hitpoints']['realLevel'] + ($skills['prayer']['realLevel'] * 0.5));
            $melee = 0.325 * ($skills['attack']['realLevel'] + $skills['strength']['realLevel']);
            $range = 0.325 * ($skills['ranged']['realLevel'] * 1.5);
            $mage = 0.325 * ($skills['magic']['realLevel'] * 1.5);

            return (int) floor($base + max($melee, $range, $mage));
        } else {
            return null;
        }
    }
}
