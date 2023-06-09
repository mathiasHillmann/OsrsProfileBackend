<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeQuestStatus;
use App\Models\Player;
use Illuminate\Support\Collection;

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
        $data['summary']['quest'] = [
            RunescapeQuestStatus::Complete->value => Collection::wrap($data['quest'])->filter(fn ($status) => $status === RunescapeQuestStatus::Complete)->count(),
            'total' => Collection::wrap($data['quest'])->count(),
        ];
        $data['summary']['miniquest'] = [
            RunescapeQuestStatus::Complete->value => Collection::wrap($data['miniquest'])->filter(fn ($status) => $status === RunescapeQuestStatus::Complete)->count(),
            'total' => Collection::wrap($data['miniquest'])->count(),
        ];
        $data['summary']['diary'] = [
            'complete' => 0,
            'total' => 492,
        ];
        $data['summary']['combatTasks'] = [
            'complete' => 0,
            'total' => 485,
        ];
        $data['summary']['collection'] = [
            'complete' => 0,
            'total' => 1443,
        ];
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
