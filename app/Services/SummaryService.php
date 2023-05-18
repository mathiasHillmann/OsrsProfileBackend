<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Player;

class SummaryService implements TranslatingInterface
{
    public function translate(array &$data, Player $player = null): void
    {
        $data['summary']['total'] = [
            'realLevel' => array_sum(array_column($data['skills'], 'realLevel')),
            'virtualLevel' => array_sum(array_column($data['skills'], 'virtualLevel')),
            'experience' => array_sum(array_column($data['skills'], 'experience')),
        ];

        $data['summary']['combat'] = $this->calculateCombatLevel($data);

        $data['summary']['updatedAt'] = $player->updated_at;
        $data['summary']['accountType'] = $player->account_type;
        $data['summary']['username'] = $player->username;
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
