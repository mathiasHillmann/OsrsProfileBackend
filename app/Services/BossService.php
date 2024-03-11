<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;
use Illuminate\Support\Facades\File;

class BossService implements OsrsService
{
    public function translate(array $data, array $hiscoreData = []): array
    {
        $bosses = $this->getValuesToTrack();
        $return = [];

        foreach ($bosses as $bossName => $boss) {
            // Skip all *_pb keys as it will be used later
            if (str_contains($bossName, '_pb')) {
                continue;
            }

            $prettyName = str_replace('_kc', '', $bossName);

            $rank = null;
            $kc = null;
            $pb = null;

            if (array_key_exists($bossName, $data)) {
                $kc = $data[$bossName];

                if ($hiscoreData && array_key_exists('hiscore_id', $boss) && $boss['hiscore_id']) {
                    $key = array_search($boss['hiscore_id'], array_column($hiscoreData['activities'], 'id'));
                    $hiscoreKc = $hiscoreData['activities'][$key]['score'];
                    $rank = $hiscoreData['activities'][$key]['rank'] ?? null;

                    if ($rank === -1) {
                        $rank = null;
                    }

                    if ($hiscoreKc > $kc) {
                        $kc = $hiscoreKc;
                    }
                }

                if ($kc !== null && $kc < 0) {
                    $kc = 0;
                }
            }

            if (array_key_exists($prettyName.'_pb', $data)) {
                $pb = $data[$prettyName.'_pb'];
            }

            $return[$prettyName] = [
                'text' => $boss['text'],
                'kc' => $kc,
                'pb' => $pb,
                'rank' => $rank,
            ];
        }

        return $return;
    }

    public function getValuesToTrack(): array
    {
        $pbs = [
            'Nex_pb' => $this->makeObject(
                'Nex',
                RunescapeTypes::PersonalBest,
            ),
            'Tempoross_pb' => $this->makeObject(
                'Tempoross',
                RunescapeTypes::PersonalBest,
            ),
            'Chambers of Xeric_pb' => $this->makeObject(
                'Chambers of Xeric',
                RunescapeTypes::PersonalBest,
            ),
            'Chambers of Xeric: CM_pb' => $this->makeObject(
                'Chambers of Xeric (Challenge mode)',
                RunescapeTypes::PersonalBest,
                null,
                'chambers of xeric challenge mode'
            ),
            'Theatre of Blood_pb' => $this->makeObject(
                'Theatre of Blood',
                RunescapeTypes::PersonalBest,
            ),
            'Theatre of Blood: Entry Mode_pb' => $this->makeObject(
                'Teather of Blood (Entry Mode)',
                RunescapeTypes::PersonalBest,
                null,
                'teather of blood entry mode'
            ),
            'Theatre of Blood: Hard Mode_pb' => $this->makeObject(
                'Teather of Blood (Hard Mode)',
                RunescapeTypes::PersonalBest,
                null,
                'teather of blood hard mode'
            ),
            'Tombs of Amascut_pb' => $this->makeObject(
                'Tombs of Amascut',
                RunescapeTypes::PersonalBest,
            ),
            'Tombs of Amascut: Entry Mode_pb' => $this->makeObject(
                'Tombs of Amascut (Entry Mode)',
                RunescapeTypes::PersonalBest,
                null,
                'tombs of amascut entry mode'
            ),
            'Tombs of Amascut: Expert Mode_pb' => $this->makeObject(
                'Tombs of Amascut (Expert Mode)',
                RunescapeTypes::PersonalBest,
                null,
                'tombs of amascut expert mode'
            ),
            'Zulrah_pb' => $this->makeObject(
                'Zulrah',
                RunescapeTypes::PersonalBest,
            ),
            'Vorkath_pb' => $this->makeObject(
                'Vorkath',
                RunescapeTypes::PersonalBest,
            ),
            'Phantom Muspah_pb' => $this->makeObject(
                'Phantom Muspah',
                RunescapeTypes::PersonalBest,
            ),
            'The Nightmare_pb' => $this->makeObject(
                'The Nightmare',
                RunescapeTypes::PersonalBest,
            ),
            "Phosani's Nightmare_pb" => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'Hespori_pb' => $this->makeObject(
                'Hespori',
                RunescapeTypes::PersonalBest,
            ),
            'Grotesque Guardians_pb' => $this->makeObject(
                'Grotesque Guardians',
                RunescapeTypes::PersonalBest,
            ),
            'Alchemical Hydra_pb' => $this->makeObject(
                'Alchemical Hydra',
                RunescapeTypes::PersonalBest,
            ),
            'Crystalline Hunllef_pb' => $this->makeObject(
                'Crystalline Hunllef',
                RunescapeTypes::PersonalBest,
            ),
            'Corrupted Hunllef_pb' => $this->makeObject(
                'Corrupted Hunllef',
                RunescapeTypes::PersonalBest,
            ),
            'TzTok-Jad_pb' => $this->makeObject(
                'TzTok-Jad',
                RunescapeTypes::PersonalBest,
                null,
                'jad'
            ),
            'TzKal-Zuk_pb' => $this->makeObject(
                'TzKal-Zuk',
                RunescapeTypes::PersonalBest,
                null,
                'zuk'
            ),
            'Leviathan_pb' => $this->makeObject(
                'Leviathan',
                RunescapeTypes::PersonalBest,
            ),
            'Whisperer_pb' => $this->makeObject(
                'Whisperer',
                RunescapeTypes::PersonalBest,
            ),
            'Vardorvis_pb' => $this->makeObject(
                'Vardorvis',
                RunescapeTypes::PersonalBest,
            ),
            'Duke Sucellus_pb' => $this->makeObject(
                'Duke Sucellus',
                RunescapeTypes::PersonalBest,
            ),
        ];

        $vars = File::json(base_path('data/boss-kc-vars.json'));

        return array_merge($vars, $pbs);
    }

    private function makeObject(
        string $text,
        RunescapeTypes $type,
        ?int $hiscoreId = null,
        ?string $index = null,
    ): array {
        return [
            'text' => $text,
            'index' => $index ?? strtolower($text),
            'type' => $type,
            'hiscore_id' => $hiscoreId,
        ];
    }
}
