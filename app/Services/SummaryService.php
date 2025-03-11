<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeQuestStatus;
use App\Enums\RunescapeTypes;
use App\Models\Player;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class SummaryService implements OsrsService
{
    public function translate(array $data, array $transformedData = [], array $hiscoreData = [], ?Player $player = null): array
    {
        $overallRank = $hiscoreData['skills'][0]['rank'] ?? null;
        if ($overallRank === -1) {
            $overallRank = null;
        }

        $return = [];

        $skills = Collection::wrap($transformedData['skills']);
        $quests = Collection::wrap($transformedData['quest']);
        $miniquests = Collection::wrap($transformedData['miniquest']);
        $tasks = Collection::wrap($transformedData['tasks']);

        $return['total'] = [
            'realLevel' => $skills->sum('realLevel'),
            'virtualLevel' => $skills->sum('virtualLevel'),
            'experience' => $skills->sum('experience'),
            'rank' => $overallRank,
        ];

        $return['combat'] = $this->calculateCombatLevel($transformedData);

        $return['updatedAt'] = $player->updated_at;
        $return['quest'] = [
            RunescapeQuestStatus::Complete->value => $quests->filter(fn ($quest) => $quest['status'] === RunescapeQuestStatus::Complete)->count(),
            'total' => $quests->count(),
        ];
        $return['miniquest'] = [
            RunescapeQuestStatus::Complete->value => $miniquests->filter(fn ($quest) => $quest['status'] === RunescapeQuestStatus::Complete)->count(),
            'total' => $miniquests->count(),
        ];
        [$diaryCompleted, $diaryTotal] = $this->countCompletedDiaries($transformedData['diaries']);
        $return['diary'] = [
            'complete' => $diaryCompleted,
            'total' => $diaryTotal,
        ];
        $return['combatTasks'] = [
            'completed' => $tasks->where('completed', true)->count(),
            'completedPoints' => $tasks->where('completed', true)->sum('points') ?? 0,
            'total' => $tasks->count(),
            'totalPoints' => $tasks->sum('points'),
        ];
        $return['combatTasks']['tier'] = $this->getCombatAchievementTier($return['combatTasks']['completedPoints']);
        $return['collection'] = [
            'complete' => $data['collection_log_total'] ?? 0,
            'total' => 1568,
        ];

        return $return;
    }

    private function calculateCombatLevel(array $data): ?int
    {
        $skills = $data['skills'];

        $attack = $skills['attack']['realLevel'] ?? 1;
        $strength = $skills['strength']['realLevel'] ?? 1;
        $defence = $skills['defence']['realLevel'] ?? 1;
        $hitpoints = $skills['hitpoints']['realLevel'] ?? 10;
        $prayer = $skills['prayer']['realLevel'] ?? 1;
        $ranged = $skills['ranged']['realLevel'] ?? 1;
        $magic = $skills['magic']['realLevel'] ?? 1;

        $base = 0.25 * ($defence + $hitpoints + ($prayer * 0.5));
        $melee = 0.325 * ($attack + $strength);
        $range = 0.325 * ($ranged * 1.5);
        $mage = 0.325 * ($magic * 1.5);

        return (int) floor($base + max($melee, $range, $mage));
    }

    private function countCompletedDiaries(array $diaries): array
    {
        $completed = 0;
        $total = 0;

        foreach ($diaries as $diary) {
            foreach ($diary as $tier) {
                if ($tier === true) {
                    ++$completed;
                }

                ++$total;
            }
        }

        return [$completed, $total];
    }

    private function getCombatAchievementTier(int $totalPoints): string
    {
        $currentTier = Collection::wrap(File::json(base_path('data/combat-achievements-tiers.json')))
            ->where('points', '<=', $totalPoints)
            ->sortByDesc('points')
            ->first();

        return $currentTier['name'] ?? 'No hilt unlocked';
    }

    public function getValuesToTrack(): array
    {
        return [
            'collection_log_total' => $this->makeObject(
                2943,
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
}
