<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class MinigameService implements OsrsService
{
    public function translate(array &$data, array $hiscoreData = []): void
    {
        $minigames = $this->getValuesToTrack();

        foreach ($minigames as $minigameName => $minigame) {
            $item = &$data[$minigameName];

            $rank = null;
            $score = null;

            if ($item) {
                $score = $item['value'];

                if ($hiscoreData && $minigame['hiscore_id']) {
                    $key = array_search($minigame['hiscore_id'], array_column($hiscoreData['activities'], 'id'));
                    $hiscoreScore = $hiscoreData['activities'][$key]['score'];
                    $rank = $hiscoreData['activities'][$key]['rank'] ?? null;

                    if ($rank === -1) {
                        $rank = null;
                    }

                    if ($hiscoreScore > $score) {
                        $score = $hiscoreScore;
                    }
                }

                if ($score !== null && $score < 0) {
                    $score = 0;
                }
            }

            $data['minigames'][$minigameName] = [
                'text' => $minigame['text'],
                'score' => $this->formattedValue($minigameName, $score),
                'rank' => $rank,
            ];

            unset($item);
            unset($data[$minigameName]);
        }
    }

    public function getValuesToTrack(): array
    {
        return [
            'clue_all' => $this->makeObject(
                "Clue Scrolls (all)",
                RunescapeTypes::Killcount,
                'clue all',
                5,
            ),
            'clue_beginner' => $this->makeObject(
                "Clue Scrolls (beginner)",
                RunescapeTypes::Killcount,
                'clue beginner',
                6,
            ),
            'clue_easy' => $this->makeObject(
                "Clue Scrolls (easy)",
                RunescapeTypes::Killcount,
                'clue easy',
                7,
            ),
            'clue_medium' => $this->makeObject(
                "Clue Scrolls (medium)",
                RunescapeTypes::Killcount,
                'clue medium',
                8,
            ),
            'clue_hard' => $this->makeObject(
                "Clue Scrolls (hard)",
                RunescapeTypes::Killcount,
                'clue hard',
                9,
            ),
            'clue_elite' => $this->makeObject(
                "Clue Scrolls (elite)",
                RunescapeTypes::Killcount,
                'clue elite',
                10,
            ),
            'clue_master' => $this->makeObject(
                "Clue Scrolls (master)",
                RunescapeTypes::Killcount,
                'clue master',
                11,
            ),
            'soul_wars' => $this->makeObject(
                "Soul Wars Zeal",
                RunescapeTypes::Killcount,
                'zeals',
                14,
            ),
            'rifts' => $this->makeObject(
                "Guardians of the Rift",
                RunescapeTypes::Killcount,
                'rifts',
                15,
            ),
            'bh_hunter' => $this->makeObject(
                "Bounty Hunter - Hunter",
                RunescapeTypes::Killcount,
                'bh hunter',
                1,
            ),
            'bh_rogue' => $this->makeObject(
                "Bounty Hunter - Rogue",
                RunescapeTypes::Killcount,
                'bh rogue',
                2,
            ),
            'lms_rank' => $this->makeObject(
                "LMS - Rank",
                RunescapeTypes::Killcount,
                'lms',
                12,
            ),
            'pvp_arena' => $this->makeObject(
                "PvP Arena - Rank",
                RunescapeTypes::Killcount,
                'pvp arena',
                13,
            ),
            'hosidius_favour' => $this->makeObject(
                "Hosidius Favour",
                RunescapeTypes::VarBit,
                '4895',
            ),
            'shayzien_favour' => $this->makeObject(
                "Shayzien Favour",
                RunescapeTypes::VarBit,
                '4894',
            ),
            'arceuus_favour' => $this->makeObject(
                "Arceuus Favour",
                RunescapeTypes::VarBit,
                '4896',
            ),
            'lovakengj_favour' => $this->makeObject(
                "Lovakengj Favour",
                RunescapeTypes::VarBit,
                '4898',
            ),
            'piscarilius_favour' => $this->makeObject(
                "Piscarilius Favour",
                RunescapeTypes::VarBit,
                '4899',
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

    private function formattedValue(string $key, int $value)
    {
        return match ($key) {
            'hosidius_favour', 'shayzien_favour', 'arceuus_favour', 'lovakengj_favour', 'piscarilius_favour' => $value / 10,
            default => $value,
        };
    }
}
