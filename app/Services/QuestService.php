<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeQuestStatus;
use Illuminate\Support\Facades\File;

class QuestService implements OsrsService
{
    public function translate(array $data): array
    {
        $quests = $this->getValuesToTrack();
        $return = [];

        foreach ($quests as $questName => $quest) {
            if (array_key_exists($questName, $data)) {
                $savedValue = $data[$questName];
                if (!$savedValue || $savedValue <= $quest['startValue']) {
                    $status = RunescapeQuestStatus::NotStarted;
                } elseif ($savedValue >= $quest['endValue']) {
                    $status = RunescapeQuestStatus::Complete;
                } else {
                    $status = RunescapeQuestStatus::InProgress;
                }
            } else {
                $status = RunescapeQuestStatus::Unknown;
            }

            $return[$quest['questType']][$questName] = [
                'text' => $quest['text'],
                'status' => $status,
            ];
        }

        return $return;
    }

    public function getValuesToTrack(): array
    {
        $data = File::json(base_path('data/quests.json'));

        uasort($data, fn ($a, $b) => strcmp($a['text'], $b['text']));

        return $data;
    }
}
