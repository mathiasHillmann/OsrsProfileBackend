<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class BossService implements OsrsService
{
    public function translate(array &$data, array $hiscoreData = []): void
    {
        $bosses = $this->getValuesToTrack();

        foreach ($bosses as $bossName => $boss) {
            // Skip all *_pb keys but don't remove them yet as it might be used later
            if (str_contains($bossName, '_pb')) {
                continue;
            }

            $prettyName = str_replace('_kc', '', $bossName);
            $item = &$data[$bossName];
            $bossPb = &$data[$prettyName . '_pb'];

            $rank = null;
            $kc = null;
            $pb = null;

            if ($item) {
                $kc = $item['value'];

                if ($hiscoreData && $boss['hiscore_id']) {
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

            if ($bossPb) {
                $pb = $bossPb['value'];
            }

            $data['bosses'][$prettyName] = [
                'text' => $boss['text'],
                'kc' => $kc,
                'pb' => $pb,
                'rank' => $rank,
            ];

            unset($item);
            unset($pb);
            unset($data[$bossName]);
        }

        // We can now remove all *_pb keys as they have been used already
        $data = array_filter($data, fn ($key) => !str_contains($key, '_pb'), ARRAY_FILTER_USE_KEY);
    }

    public function getValuesToTrack(): array
    {
        return [
            'barrows_kc' => $this->makeObject(
                "Barrows' Brothers",
                RunescapeTypes::Killcount,
                19,
                'barrows chests',
            ),
            'giant_mole_kc' => $this->makeObject(
                "Giant Mole",
                RunescapeTypes::Killcount,
                37,
            ),
            'deranged_archaeologist_kc' => $this->makeObject(
                "Deranged Archaeologist",
                RunescapeTypes::Killcount,
                50,
            ),
            'dagannoth_supreme_kc' => $this->makeObject(
                "Dagannoth Supreme",
                RunescapeTypes::Killcount,
                33,
            ),
            'dagannoth_rex_kc' => $this->makeObject(
                "Dagannoth Rex",
                RunescapeTypes::Killcount,
                32,
            ),
            'dagannoth_prime_kc' => $this->makeObject(
                "Dagannoth Prime",
                RunescapeTypes::Killcount,
                31,
            ),
            'sarachnis_kc' => $this->makeObject(
                "Sarachnis",
                RunescapeTypes::Killcount,
                51,
            ),
            'kalphite_queen_kc' => $this->makeObject(
                "Kalphite Queen",
                RunescapeTypes::Killcount,
                65,
            ),
            'kree_arra_kc' => $this->makeObject(
                "Kree'arra",
                RunescapeTypes::Killcount,
                67,
            ),
            'commander_zilyana_kc' => $this->makeObject(
                "Commander Zilyana",
                RunescapeTypes::Killcount,
                28,
            ),
            'general_graardor_kc' => $this->makeObject(
                "General Graardor",
                RunescapeTypes::Killcount,
                36,
            ),
            'kril_tsutsaroth_kc' => $this->makeObject(
                "K'ril Tsutsaroth",
                RunescapeTypes::Killcount,
                44,
            ),
            'corporeal_beast_kc' => $this->makeObject(
                "Corporeal Beast",
                RunescapeTypes::Killcount,
                29,
            ),
            'nex_kc' => $this->makeObject(
                "Nex",
                RunescapeTypes::Killcount,
                46,
            ),
            'nex_pb' => $this->makeObject(
                "Nex",
                RunescapeTypes::PersonalBest,
            ),
            'tempoross_kc' => $this->makeObject(
                "Tempoross",
                RunescapeTypes::Killcount,
                55,
            ),
            'tempoross_pb' => $this->makeObject(
                "Tempoross",
                RunescapeTypes::PersonalBest,
            ),
            'wintertodt_kc' => $this->makeObject(
                "Wintertodt",
                RunescapeTypes::Killcount,
                71,
            ),
            'zalcano_kc' => $this->makeObject(
                "Zalcano",
                RunescapeTypes::Killcount,
                72,
            ),
            'chambers_kc' => $this->makeObject(
                "Chambers of Xeric",
                RunescapeTypes::Killcount,
                24,
            ),
            'chambers_pb' => $this->makeObject(
                "Chambers of Xeric",
                RunescapeTypes::PersonalBest,
            ),
            'chambers_challenge_kc' => $this->makeObject(
                "Chambers of Xeric (Challenge mode)",
                RunescapeTypes::Killcount,
                25,
                'chambers of xeric challenge mode'
            ),
            'chambers_challenge_pb' => $this->makeObject(
                "Chambers of Xeric (Challenge mode)",
                RunescapeTypes::PersonalBest,
                null,
                'chambers of xeric challenge mode'
            ),
            'theatre_of_blood_kc' => $this->makeObject(
                "Theatre of Blood",
                RunescapeTypes::Killcount,
                60,
            ),
            'theatre_of_blood_pb' => $this->makeObject(
                "Theatre of Blood",
                RunescapeTypes::PersonalBest,
            ),
            'theatre_of_blood_entry_kc' => $this->makeObject(
                "Theatre of Blood (Entry Mode)",
                RunescapeTypes::Killcount,
                null,
                'teather of blood entry mode'
            ),
            'teather_of_blood_entry_pb' => $this->makeObject(
                "Teather of Blood (Entry Mode)",
                RunescapeTypes::PersonalBest,
                null,
                'teather of blood entry mode'
            ),
            'teather_of_blood_hard_kc' => $this->makeObject(
                "Teather of Blood (Hard Mode)",
                RunescapeTypes::Killcount,
                61,
                'teather of blood hard mode'
            ),
            'teather_of_blood_hard_pb' => $this->makeObject(
                "Teather of Blood (Hard Mode)",
                RunescapeTypes::PersonalBest,
                null,
                'teather of blood hard mode'
            ),
            'tombs_of_amascut_kc' => $this->makeObject(
                "Tombs of Amascut",
                RunescapeTypes::Killcount,
                63,
            ),
            'tombs_of_amascut_pb' => $this->makeObject(
                "Tombs of Amascut",
                RunescapeTypes::PersonalBest,
            ),
            'tombs_of_amascut_entry_kc' => $this->makeObject(
                "Tombs of Amascut (Entry Mode)",
                RunescapeTypes::Killcount,
                null,
                'tombs of amascut entry mode'
            ),
            'tombs_of_amascut_entry_pb' => $this->makeObject(
                "Tombs of Amascut (Entry Mode)",
                RunescapeTypes::PersonalBest,
                null,
                'tombs of amascut entry mode'
            ),
            'tombs_of_amascut_expert_kc' => $this->makeObject(
                "Tombs of Amascut (Expert Mode)",
                RunescapeTypes::Killcount,
                64,
                'tombs of amascut expert mode'
            ),
            'tombs_of_amascut_expert_pb' => $this->makeObject(
                "Tombs of Amascut (Expert Mode)",
                RunescapeTypes::PersonalBest,
                null,
                'tombs of amascut expert mode'
            ),
            'artio_kc' => $this->makeObject(
                "Artio",
                RunescapeTypes::Killcount,
                18,
            ),
            'callisto_kc' => $this->makeObject(
                "Callisto",
                RunescapeTypes::Killcount,
                21,
            ),
            'calvarion_kc' => $this->makeObject(
                "Calvar'ion",
                RunescapeTypes::Killcount,
                22,
            ),
            'vetion_kc' => $this->makeObject(
                "Vet'ion",
                RunescapeTypes::Killcount,
                69,
            ),
            'chaos_elemental_kc' => $this->makeObject(
                "Chaos Elemental",
                RunescapeTypes::Killcount,
                45,
            ),
            'chaos_fanatic_kc' => $this->makeObject(
                "Chaos Fanatic",
                RunescapeTypes::Killcount,
                27,
            ),
            'crazy_achaeologist_kc' => $this->makeObject(
                "Crazy Archaeologist",
                RunescapeTypes::Killcount,
                30,
            ),
            'king_black_dragon_kc' => $this->makeObject(
                "King Black Dragon",
                RunescapeTypes::Killcount,
                41,
            ),
            'revenant_maledictus_kc' => $this->makeObject(
                "Revenant Maledictus",
                RunescapeTypes::Killcount,
            ),
            'scorpia_kc' => $this->makeObject(
                "Scorpia",
                RunescapeTypes::Killcount,
                52,
            ),
            'spindel_kc' => $this->makeObject(
                "Spindel",
                RunescapeTypes::Killcount,
                54,
            ),
            'venenatis_kc' => $this->makeObject(
                "Venenatis",
                RunescapeTypes::Killcount,
                68,
            ),
            'zulrah_kc' => $this->makeObject(
                "Zulrah",
                RunescapeTypes::Killcount,
                73,
            ),
            'zulrah_pb' => $this->makeObject(
                "Zulrah",
                RunescapeTypes::PersonalBest,
            ),
            'vorkath_kc' => $this->makeObject(
                "Vorkath",
                RunescapeTypes::Killcount,
                70,
            ),
            'vorkath_pb' => $this->makeObject(
                "Vorkath",
                RunescapeTypes::PersonalBest,
            ),
            'phantom_muspah_kc' => $this->makeObject(
                "Phantom Muspah",
                RunescapeTypes::Killcount,
                50,
            ),
            'phantom_muspah_pb' => $this->makeObject(
                "Phantom Muspah",
                RunescapeTypes::PersonalBest,
            ),
            'nightmare_kc' => $this->makeObject(
                "The Nightmare",
                RunescapeTypes::Killcount,
                47,
            ),
            'nightmare_pb' => $this->makeObject(
                "The Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'phosanis_nightmare_kc' => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::Killcount,
                48,
            ),
            'phosanis_nightmare_pb' => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'obor_kc' => $this->makeObject(
                "Obor",
                RunescapeTypes::Killcount,
                49,
            ),
            'Bryophyta_kc' => $this->makeObject(
                "Bryophyta",
                RunescapeTypes::Killcount,
                20,
            ),
            'the_mimic_kc' => $this->makeObject(
                "The Mimic",
                RunescapeTypes::Killcount,
                45,
            ),
            'hespori_kc' => $this->makeObject(
                "Hespori",
                RunescapeTypes::Killcount,
                39,
            ),
            'hespori_pb' => $this->makeObject(
                "Hespori",
                RunescapeTypes::PersonalBest,
            ),
            'skotizo_kc' => $this->makeObject(
                "Skotizo",
                RunescapeTypes::Killcount,
                53,
            ),
            'grotesque_guardians_kc' => $this->makeObject(
                "Grotesque Guardians",
                RunescapeTypes::Killcount,
            ),
            'grotesque_guardians_pb' => $this->makeObject(
                "Grotesque Guardians",
                RunescapeTypes::PersonalBest,
                38,
            ),
            'abyssal_sire_kc' => $this->makeObject(
                "Abyssal Sire",
                RunescapeTypes::Killcount,
                16,
            ),
            'kraken_kc' => $this->makeObject(
                "Kraken",
                RunescapeTypes::Killcount,
                42,
            ),
            'cerberus_kc' => $this->makeObject(
                "Cerberus",
                RunescapeTypes::Killcount,
                23,
            ),
            'thermonuclear_kc' => $this->makeObject(
                "Thermonuclear Smoke Devil",
                RunescapeTypes::Killcount,
                62,
            ),
            'alchemical_hydra_kc' => $this->makeObject(
                "Alchemical Hydra",
                RunescapeTypes::Killcount,
                17,
            ),
            'alchemical_hydra_pb' => $this->makeObject(
                "Alchemical Hydra",
                RunescapeTypes::PersonalBest,
            ),
            'gauntlet_kc' => $this->makeObject(
                "Gauntlet",
                RunescapeTypes::Killcount,
                56,
            ),
            'gauntlet_pb' => $this->makeObject(
                "Gauntlet",
                RunescapeTypes::PersonalBest,
            ),
            'corrupted_gauntlet_kc' => $this->makeObject(
                "Corrupted Gauntlet",
                RunescapeTypes::Killcount,
                57,
            ),
            'corrupted_gauntlet_pb' => $this->makeObject(
                "Corrupted Gauntlet",
                RunescapeTypes::PersonalBest,
            ),
            'jad_kc' => $this->makeObject(
                "TzTok-Jad",
                RunescapeTypes::Killcount,
                66,
                'jad'
            ),
            'jad_pb' => $this->makeObject(
                "TzTok-Jad",
                RunescapeTypes::PersonalBest,
                null,
                'jad'
            ),
            'zuk_kc' => $this->makeObject(
                "TzKal-Zuk",
                RunescapeTypes::Killcount,
                65,
                'zuk'
            ),
            'zuk_pb' => $this->makeObject(
                "TzKal-Zuk",
                RunescapeTypes::PersonalBest,
                null,
                'zuk'
            ),
            'the_leviathan_kc' => $this->makeObject(
                "The Leviathan",
                RunescapeTypes::Killcount,
                58,
            ),
            'the_leviathan_pb' => $this->makeObject(
                "The Leviathan",
                RunescapeTypes::PersonalBest,
            ),
            'the_whisperer_kc' => $this->makeObject(
                "The Whisperer",
                RunescapeTypes::Killcount,
                59,
            ),
            'the_whisperer_pb' => $this->makeObject(
                "The Whisperer",
                RunescapeTypes::PersonalBest,
            ),
            'vardorvis_kc' => $this->makeObject(
                "Vardorvis",
                RunescapeTypes::Killcount,
                67,
            ),
            'vardorvis_pb' => $this->makeObject(
                "Vardorvis",
                RunescapeTypes::PersonalBest,
            ),
            'duke_sucellus_kc' => $this->makeObject(
                "Duke Sucellus",
                RunescapeTypes::Killcount,
                35
            ),
            'duke_sucellus_pb' => $this->makeObject(
                "Duke Sucellus",
                RunescapeTypes::PersonalBest,
            ),
        ];
    }

    private function makeObject(
        string $text,
        RunescapeTypes $type,
        int $hiscoreId = null,
        string $index = null,
    ): array {
        return [
            'text' => $text,
            'index' => $index ?? strtolower($text),
            'type' => $type,
            'hiscore_id' => $hiscoreId,
        ];
    }
}
