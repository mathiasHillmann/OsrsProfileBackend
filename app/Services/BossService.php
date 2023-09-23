<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

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

            if (array_key_exists($prettyName . '_pb', $data)) {
                $pb = $data[$prettyName . '_pb'];
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
        return [
            'barrows_kc' => $this->makeObject(
                "Barrows' Brothers",
                RunescapeTypes::Killcount,
                20,
                'barrows chests',
            ),
            'giant_mole_kc' => $this->makeObject(
                "Giant Mole",
                RunescapeTypes::Killcount,
                38,
            ),
            'deranged_archaeologist_kc' => $this->makeObject(
                "Deranged Archaeologist",
                RunescapeTypes::Killcount,
                35,
            ),
            'dagannoth_supreme_kc' => $this->makeObject(
                "Dagannoth Supreme",
                RunescapeTypes::Killcount,
                34,
            ),
            'dagannoth_rex_kc' => $this->makeObject(
                "Dagannoth Rex",
                RunescapeTypes::Killcount,
                33,
            ),
            'dagannoth_prime_kc' => $this->makeObject(
                "Dagannoth Prime",
                RunescapeTypes::Killcount,
                32,
            ),
            'sarachnis_kc' => $this->makeObject(
                "Sarachnis",
                RunescapeTypes::Killcount,
                52,
            ),
            'kalphite_queen_kc' => $this->makeObject(
                "Kalphite Queen",
                RunescapeTypes::Killcount,
                41,
            ),
            'kree_arra_kc' => $this->makeObject(
                "Kree'arra",
                RunescapeTypes::Killcount,
                44,
            ),
            'commander_zilyana_kc' => $this->makeObject(
                "Commander Zilyana",
                RunescapeTypes::Killcount,
                29,
            ),
            'general_graardor_kc' => $this->makeObject(
                "General Graardor",
                RunescapeTypes::Killcount,
                37,
            ),
            'kril_tsutsaroth_kc' => $this->makeObject(
                "K'ril Tsutsaroth",
                RunescapeTypes::Killcount,
                45,
            ),
            'corporeal_beast_kc' => $this->makeObject(
                "Corporeal Beast",
                RunescapeTypes::Killcount,
                30,
            ),
            'nex_kc' => $this->makeObject(
                "Nex",
                RunescapeTypes::Killcount,
                47,
            ),
            'nex_pb' => $this->makeObject(
                "Nex",
                RunescapeTypes::PersonalBest,
            ),
            'tempoross_kc' => $this->makeObject(
                "Tempoross",
                RunescapeTypes::Killcount,
                56,
            ),
            'tempoross_pb' => $this->makeObject(
                "Tempoross",
                RunescapeTypes::PersonalBest,
            ),
            'wintertodt_kc' => $this->makeObject(
                "Wintertodt",
                RunescapeTypes::Killcount,
                72,
            ),
            'zalcano_kc' => $this->makeObject(
                "Zalcano",
                RunescapeTypes::Killcount,
                73,
            ),
            'chambers_kc' => $this->makeObject(
                "Chambers of Xeric",
                RunescapeTypes::Killcount,
                25,
            ),
            'chambers_pb' => $this->makeObject(
                "Chambers of Xeric",
                RunescapeTypes::PersonalBest,
            ),
            'chambers_challenge_kc' => $this->makeObject(
                "Chambers of Xeric (Challenge mode)",
                RunescapeTypes::Killcount,
                26,
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
                61,
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
                62,
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
                64,
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
                65,
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
                19,
            ),
            'callisto_kc' => $this->makeObject(
                "Callisto",
                RunescapeTypes::Killcount,
                22,
            ),
            'calvarion_kc' => $this->makeObject(
                "Calvar'ion",
                RunescapeTypes::Killcount,
                23,
            ),
            'vetion_kc' => $this->makeObject(
                "Vet'ion",
                RunescapeTypes::Killcount,
                70,
            ),
            'chaos_elemental_kc' => $this->makeObject(
                "Chaos Elemental",
                RunescapeTypes::Killcount,
                27,
            ),
            'chaos_fanatic_kc' => $this->makeObject(
                "Chaos Fanatic",
                RunescapeTypes::Killcount,
                28,
            ),
            'crazy_achaeologist_kc' => $this->makeObject(
                "Crazy Archaeologist",
                RunescapeTypes::Killcount,
                31,
            ),
            'king_black_dragon_kc' => $this->makeObject(
                "King Black Dragon",
                RunescapeTypes::Killcount,
                42,
            ),
            'revenant_maledictus_kc' => $this->makeObject(
                "Revenant Maledictus",
                RunescapeTypes::Killcount,
            ),
            'scorpia_kc' => $this->makeObject(
                "Scorpia",
                RunescapeTypes::Killcount,
                53,
            ),
            'spindel_kc' => $this->makeObject(
                "Spindel",
                RunescapeTypes::Killcount,
                55,
            ),
            'venenatis_kc' => $this->makeObject(
                "Venenatis",
                RunescapeTypes::Killcount,
                69,
            ),
            'zulrah_kc' => $this->makeObject(
                "Zulrah",
                RunescapeTypes::Killcount,
                74,
            ),
            'zulrah_pb' => $this->makeObject(
                "Zulrah",
                RunescapeTypes::PersonalBest,
            ),
            'vorkath_kc' => $this->makeObject(
                "Vorkath",
                RunescapeTypes::Killcount,
                71,
            ),
            'vorkath_pb' => $this->makeObject(
                "Vorkath",
                RunescapeTypes::PersonalBest,
            ),
            'phantom_muspah_kc' => $this->makeObject(
                "Phantom Muspah",
                RunescapeTypes::Killcount,
                51,
            ),
            'phantom_muspah_pb' => $this->makeObject(
                "Phantom Muspah",
                RunescapeTypes::PersonalBest,
            ),
            'nightmare_kc' => $this->makeObject(
                "The Nightmare",
                RunescapeTypes::Killcount,
                48,
            ),
            'nightmare_pb' => $this->makeObject(
                "The Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'phosanis_nightmare_kc' => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::Killcount,
                49,
            ),
            'phosanis_nightmare_pb' => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'obor_kc' => $this->makeObject(
                "Obor",
                RunescapeTypes::Killcount,
                50,
            ),
            'Bryophyta_kc' => $this->makeObject(
                "Bryophyta",
                RunescapeTypes::Killcount,
                21,
            ),
            'the_mimic_kc' => $this->makeObject(
                "The Mimic",
                RunescapeTypes::Killcount,
                46,
            ),
            'hespori_kc' => $this->makeObject(
                "Hespori",
                RunescapeTypes::Killcount,
                40,
            ),
            'hespori_pb' => $this->makeObject(
                "Hespori",
                RunescapeTypes::PersonalBest,
            ),
            'skotizo_kc' => $this->makeObject(
                "Skotizo",
                RunescapeTypes::Killcount,
                54,
            ),
            'grotesque_guardians_kc' => $this->makeObject(
                "Grotesque Guardians",
                RunescapeTypes::Killcount,
                39,
            ),
            'grotesque_guardians_pb' => $this->makeObject(
                "Grotesque Guardians",
                RunescapeTypes::PersonalBest,
            ),
            'abyssal_sire_kc' => $this->makeObject(
                "Abyssal Sire",
                RunescapeTypes::Killcount,
                17,
            ),
            'kraken_kc' => $this->makeObject(
                "Kraken",
                RunescapeTypes::Killcount,
                43,
            ),
            'cerberus_kc' => $this->makeObject(
                "Cerberus",
                RunescapeTypes::Killcount,
                24,
            ),
            'thermonuclear_kc' => $this->makeObject(
                "Thermonuclear Smoke Devil",
                RunescapeTypes::Killcount,
                63,
            ),
            'alchemical_hydra_kc' => $this->makeObject(
                "Alchemical Hydra",
                RunescapeTypes::Killcount,
                18,
            ),
            'alchemical_hydra_pb' => $this->makeObject(
                "Alchemical Hydra",
                RunescapeTypes::PersonalBest,
            ),
            'gauntlet_kc' => $this->makeObject(
                "Gauntlet",
                RunescapeTypes::Killcount,
                57,
            ),
            'gauntlet_pb' => $this->makeObject(
                "Gauntlet",
                RunescapeTypes::PersonalBest,
            ),
            'corrupted_gauntlet_kc' => $this->makeObject(
                "Corrupted Gauntlet",
                RunescapeTypes::Killcount,
                58,
            ),
            'corrupted_gauntlet_pb' => $this->makeObject(
                "Corrupted Gauntlet",
                RunescapeTypes::PersonalBest,
            ),
            'jad_kc' => $this->makeObject(
                "TzTok-Jad",
                RunescapeTypes::Killcount,
                67,
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
                66,
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
                59,
            ),
            'the_leviathan_pb' => $this->makeObject(
                "The Leviathan",
                RunescapeTypes::PersonalBest,
            ),
            'the_whisperer_kc' => $this->makeObject(
                "The Whisperer",
                RunescapeTypes::Killcount,
                60,
            ),
            'the_whisperer_pb' => $this->makeObject(
                "The Whisperer",
                RunescapeTypes::PersonalBest,
            ),
            'vardorvis_kc' => $this->makeObject(
                "Vardorvis",
                RunescapeTypes::Killcount,
                68,
            ),
            'vardorvis_pb' => $this->makeObject(
                "Vardorvis",
                RunescapeTypes::PersonalBest,
            ),
            'duke_sucellus_kc' => $this->makeObject(
                "Duke Sucellus",
                RunescapeTypes::Killcount,
                36
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
