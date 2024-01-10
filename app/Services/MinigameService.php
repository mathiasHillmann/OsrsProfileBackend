<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class MinigameService implements OsrsService
{
    public function translate(array $data, array $hiscoreData = []): array
    {
        $minigames = $this->getValuesToTrack();
        $return = [];

        foreach ($minigames as $minigameName => $minigame) {
            $rank = null;
            $score = null;

            if (array_key_exists($minigameName, $data)) {
                $score = $data[$minigameName];

                if ($hiscoreData && $minigame['hiscore_id']) {
                    $hiscore = $hiscoreData['activities'][$minigame['hiscore_id']] ?? [];

                    if ($hiscore) {
                        $hiscoreScore = $hiscore['score'];
                        $rank = $hiscore['rank'] ?? null;

                        if ($rank === -1) {
                            $rank = null;
                        }

                        if ($hiscoreScore > $score) {
                            $score = $hiscoreScore;
                        }
                    }
                }

                if ($score !== null && $score < 0) {
                    $score = 0;
                }
            }

            $return[$minigameName] = [
                'text' => $minigame['text'],
                'score' => $score,
                'rank' => $rank,
            ];
        }

        return $return;
    }

    public function getValuesToTrack(): array
    {
        return [
            'clue_all' => $this->makeObject(
                "Clue Scrolls (all)",
                RunescapeTypes::Killcount,
                'clue all',
                6,
            ),
            'clue_beginner' => $this->makeObject(
                "Clue Scrolls (beginner)",
                RunescapeTypes::Killcount,
                'clue beginner',
                7,
            ),
            'clue_easy' => $this->makeObject(
                "Clue Scrolls (easy)",
                RunescapeTypes::Killcount,
                'clue easy',
                8,
            ),
            'clue_medium' => $this->makeObject(
                "Clue Scrolls (medium)",
                RunescapeTypes::Killcount,
                'clue medium',
                9,
            ),
            'clue_hard' => $this->makeObject(
                "Clue Scrolls (hard)",
                RunescapeTypes::Killcount,
                'clue hard',
                10,
            ),
            'clue_elite' => $this->makeObject(
                "Clue Scrolls (elite)",
                RunescapeTypes::Killcount,
                'clue elite',
                11,
            ),
            'clue_master' => $this->makeObject(
                "Clue Scrolls (master)",
                RunescapeTypes::Killcount,
                'clue master',
                12,
            ),
            'soul_wars' => $this->makeObject(
                "Soul Wars Zeal",
                RunescapeTypes::Killcount,
                'zeals',
                15,
            ),
            'rifts' => $this->makeObject(
                "Guardians of the Rift",
                RunescapeTypes::Killcount,
                'rifts',
                16,
            ),
            'bh_hunter' => $this->makeObject(
                "Bounty Hunter - Hunter",
                RunescapeTypes::Killcount,
                'bh hunter',
                2,
            ),
            'bh_rogue' => $this->makeObject(
                "Bounty Hunter - Rogue",
                RunescapeTypes::Killcount,
                'bh rogue',
                3,
            ),
            'lms_rank' => $this->makeObject(
                "LMS - Rank",
                RunescapeTypes::Killcount,
                'lms',
                13,
            ),
            'pvp_arena' => $this->makeObject(
                "PvP Arena - Rank",
                RunescapeTypes::Killcount,
                'pvp arena',
                14,
            ),
        ];
    }

    private function makeObject(
        string $text,
        RunescapeTypes $type,
        string $index = null,
        int $hiscoreId = null,
    ): array {
        return [
            'text' => $text,
            'index' => $index ?? strtolower($text),
            'type' => $type,
            'hiscore_id' => $hiscoreId ?? $text,
        ];
    }
}
