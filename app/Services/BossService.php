<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class BossService implements OsrsService
{
    public function translate(array &$data): void
    {
        $boss = $this->getValuesToTrack();

        foreach ($boss as $bossName => $boss) {
            if (str_contains($bossName, '_pb')) {
                continue;
            }

            $prettyName = str_replace('_kc', '', $bossName);

            $item = &$data[$bossName];
            $pb = &$data[$prettyName . '_pb'];

            $data['bosses'][$prettyName] = [
                'text' => $boss['text'],
                'kc' => $item['value'] ?? null,
                'pb' => $pb['value'] ?? null,
            ];

            unset($item);
            unset($pb);
            unset($data[$bossName]);
        }

        $data = array_filter($data, fn ($key) => !str_contains($key, '_pb'), ARRAY_FILTER_USE_KEY);
    }

    public function getValuesToTrack(): array
    {
        return [
            'barrows_kc' => $this->makeObject(
                "Barrows' Brothers",
                RunescapeTypes::Killcount,
                'barrows chests',
            ),
            'giant_mole_kc' => $this->makeObject(
                "Giant Mole",
                RunescapeTypes::Killcount,
            ),
            'deranged_archaeologist_kc' => $this->makeObject(
                "Deranged Archaeologist",
                RunescapeTypes::Killcount,
            ),
            'dagannoth_supreme_kc' => $this->makeObject(
                "Dagannoth Supreme",
                RunescapeTypes::Killcount,
            ),
            'dagannoth_rex_kc' => $this->makeObject(
                "Dagannoth Rex",
                RunescapeTypes::Killcount,
            ),
            'dagannoth_prime_kc' => $this->makeObject(
                "Dagannoth Prime",
                RunescapeTypes::Killcount,
            ),
            'sarachnis_kc' => $this->makeObject(
                "Sarachnis",
                RunescapeTypes::Killcount,
            ),
            'kalphite_queen_kc' => $this->makeObject(
                "Kalphite Queen",
                RunescapeTypes::Killcount,
            ),
            'kree_arra_kc' => $this->makeObject(
                "Kree'arra",
                RunescapeTypes::Killcount,
            ),
            'commander_zilyana_kc' => $this->makeObject(
                "Commander Zilyana",
                RunescapeTypes::Killcount,
            ),
            'general_graardor_kc' => $this->makeObject(
                "General Graardor",
                RunescapeTypes::Killcount,
            ),
            'kril_tsutsaroth_kc' => $this->makeObject(
                "K'ril Tsutsaroth",
                RunescapeTypes::Killcount,
            ),
            'corporeal_beast_kc' => $this->makeObject(
                "Corporeal Beast",
                RunescapeTypes::Killcount,
            ),
            'nex_kc' => $this->makeObject(
                "Nex",
                RunescapeTypes::Killcount,
            ),
            'nex_pb' => $this->makeObject(
                "Nex",
                RunescapeTypes::PersonalBest,
            ),
            'tempoross_kc' => $this->makeObject(
                "Tempoross",
                RunescapeTypes::Killcount,
            ),
            'tempoross_pb' => $this->makeObject(
                "Tempoross",
                RunescapeTypes::PersonalBest,
            ),
            'wintertodt_kc' => $this->makeObject(
                "Wintertodt",
                RunescapeTypes::Killcount,
            ),
            'zalcano_kc' => $this->makeObject(
                "Zalcano",
                RunescapeTypes::Killcount,
            ),
            'chambers_kc' => $this->makeObject(
                "Chambers of Xeric",
                RunescapeTypes::Killcount,
            ),
            'chambers_pb' => $this->makeObject(
                "Chambers of Xeric",
                RunescapeTypes::PersonalBest,
            ),
            'chambers_challenge_kc' => $this->makeObject(
                "Chambers of Xeric (Challenge mode)",
                RunescapeTypes::Killcount,
                'chambers of xeric challenge mode'
            ),
            'chambers_challenge_pb' => $this->makeObject(
                "Chambers of Xeric (Challenge mode)",
                RunescapeTypes::PersonalBest,
                'chambers of xeric challenge mode'
            ),
            'teather_of_blood_kc' => $this->makeObject(
                "Teather of Blood",
                RunescapeTypes::Killcount,
            ),
            'teather_of_blood_pb' => $this->makeObject(
                "Teather of Blood",
                RunescapeTypes::PersonalBest,
            ),
            'teather_of_blood_entry_kc' => $this->makeObject(
                "Teather of Blood (Entry Mode)",
                RunescapeTypes::Killcount,
                'teather of blood entry mode'
            ),
            'teather_of_blood_entry_pb' => $this->makeObject(
                "Teather of Blood (Entry Mode)",
                RunescapeTypes::PersonalBest,
                'teather of blood entry mode'
            ),
            'teather_of_blood_hard_kc' => $this->makeObject(
                "Teather of Blood (Hard Mode)",
                RunescapeTypes::Killcount,
                'teather of blood hard mode'
            ),
            'teather_of_blood_hard_pb' => $this->makeObject(
                "Teather of Blood (Hard Mode)",
                RunescapeTypes::PersonalBest,
                'teather of blood hard mode'
            ),
            'tombs_of_amascut_kc' => $this->makeObject(
                "Tombs of Amascut",
                RunescapeTypes::Killcount,
            ),
            'tombs_of_amascut_pb' => $this->makeObject(
                "Tombs of Amascut",
                RunescapeTypes::PersonalBest,
            ),
            'tombs_of_amascut_entry_kc' => $this->makeObject(
                "Tombs of Amascut (Entry Mode)",
                RunescapeTypes::Killcount,
                'tombs of amascut entry mode'
            ),
            'tombs_of_amascut_entry_pb' => $this->makeObject(
                "Tombs of Amascut (Entry Mode)",
                RunescapeTypes::PersonalBest,
                'tombs of amascut entry mode'
            ),
            'tombs_of_amascut_expert_kc' => $this->makeObject(
                "Tombs of Amascut (Expert Mode)",
                RunescapeTypes::Killcount,
                'tombs of amascut expert mode'
            ),
            'tombs_of_amascut_expert_pb' => $this->makeObject(
                "Tombs of Amascut (Expert Mode)",
                RunescapeTypes::PersonalBest,
                'tombs of amascut expert mode'
            ),
            'artio_kc' => $this->makeObject(
                "Artio",
                RunescapeTypes::Killcount,
            ),
            'callisto_kc' => $this->makeObject(
                "Callisto",
                RunescapeTypes::Killcount,
            ),
            'calvarion_kc' => $this->makeObject(
                "Calvar'ion",
                RunescapeTypes::Killcount,
            ),
            'vetion_kc' => $this->makeObject(
                "Vet'ion",
                RunescapeTypes::Killcount,
            ),
            'chaos_elemental_kc' => $this->makeObject(
                "Chaos Elemental",
                RunescapeTypes::Killcount,
            ),
            'chaos_fanatic_kc' => $this->makeObject(
                "Chaos Fanatic",
                RunescapeTypes::Killcount,
            ),
            'crazy_achaeologist_kc' => $this->makeObject(
                "Crazy Archaeologist",
                RunescapeTypes::Killcount,
            ),
            'king_black_dragon_kc' => $this->makeObject(
                "King Black Dragon",
                RunescapeTypes::Killcount,
            ),
            'revenant_maledictus_kc' => $this->makeObject(
                "Revenant Maledictus",
                RunescapeTypes::Killcount,
            ),
            'scorpia_kc' => $this->makeObject(
                "Scorpia",
                RunescapeTypes::Killcount,
            ),
            'spindel_kc' => $this->makeObject(
                "Spindel",
                RunescapeTypes::Killcount,
            ),
            'venenatis_kc' => $this->makeObject(
                "Venenatis",
                RunescapeTypes::Killcount,
            ),
            'zulrah_kc' => $this->makeObject(
                "Zulrah",
                RunescapeTypes::Killcount,
            ),
            'zulrah_pb' => $this->makeObject(
                "Zulrah",
                RunescapeTypes::PersonalBest,
            ),
            'vorkath_kc' => $this->makeObject(
                "Vorkath",
                RunescapeTypes::Killcount,
            ),
            'vorkath_pb' => $this->makeObject(
                "Vorkath",
                RunescapeTypes::PersonalBest,
            ),
            'phantom_muspah_kc' => $this->makeObject(
                "Phantom Muspah",
                RunescapeTypes::Killcount,
            ),
            'phantom_muspah_pb' => $this->makeObject(
                "Phantom Muspah",
                RunescapeTypes::PersonalBest,
            ),
            'nightmare_kc' => $this->makeObject(
                "The Nightmare",
                RunescapeTypes::Killcount,
            ),
            'nightmare_pb' => $this->makeObject(
                "The Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'phosanis_nightmare_kc' => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::Killcount,
            ),
            'phosanis_nightmare_pb' => $this->makeObject(
                "Phosani's Nightmare",
                RunescapeTypes::PersonalBest,
            ),
            'obor_kc' => $this->makeObject(
                "Obor",
                RunescapeTypes::Killcount,
            ),
            'Bryophyta_kc' => $this->makeObject(
                "Bryophyta",
                RunescapeTypes::Killcount,
            ),
            'the_mimic_kc' => $this->makeObject(
                "The Mimic",
                RunescapeTypes::Killcount,
            ),
            'hespori_kc' => $this->makeObject(
                "Hespori",
                RunescapeTypes::Killcount,
            ),
            'hespori_pb' => $this->makeObject(
                "Hespori",
                RunescapeTypes::PersonalBest,
            ),
            'skotizo_kc' => $this->makeObject(
                "Skotizo",
                RunescapeTypes::Killcount,
            ),
            'grotesque_guardians_kc' => $this->makeObject(
                "Grotesque Guardians",
                RunescapeTypes::Killcount,
            ),
            'grotesque_guardians_pb' => $this->makeObject(
                "Grotesque Guardians",
                RunescapeTypes::PersonalBest,
            ),
            'abyssal_sire_kc' => $this->makeObject(
                "Abyssal Sire",
                RunescapeTypes::Killcount,
            ),
            'kraken_kc' => $this->makeObject(
                "Kraken",
                RunescapeTypes::Killcount,
            ),
            'cerberus_kc' => $this->makeObject(
                "Cerberus",
                RunescapeTypes::Killcount,
            ),
            'thermonuclear_kc' => $this->makeObject(
                "Thermonuclear Smoke Devil",
                RunescapeTypes::Killcount,
            ),
            'alchemical_hydra_kc' => $this->makeObject(
                "Alchemical Hydra",
                RunescapeTypes::Killcount,
            ),
            'alchemical_hydra_pb' => $this->makeObject(
                "Alchemical Hydra",
                RunescapeTypes::PersonalBest,
            ),
            'gauntlet_kc' => $this->makeObject(
                "Gauntlet",
                RunescapeTypes::Killcount,
            ),
            'gauntlet_pb' => $this->makeObject(
                "Gauntlet",
                RunescapeTypes::PersonalBest,
            ),
            'corrupted_gauntlet_kc' => $this->makeObject(
                "Corrupted Gauntlet",
                RunescapeTypes::Killcount,
            ),
            'corrupted_gauntlet_pb' => $this->makeObject(
                "Corrupted Gauntlet",
                RunescapeTypes::PersonalBest,
            ),
            'jad_kc' => $this->makeObject(
                "TzTok-Jad",
                RunescapeTypes::Killcount,
                'jad'
            ),
            'jad_pb' => $this->makeObject(
                "TzTok-Jad",
                RunescapeTypes::PersonalBest,
                'jad'
            ),
            'zuk_kc' => $this->makeObject(
                "TzKal-Zuk",
                RunescapeTypes::Killcount,
                'zuk'
            ),
            'zuk_pb' => $this->makeObject(
                "TzKal-Zuk",
                RunescapeTypes::PersonalBest,
                'zuk'
            ),
            'the_leviathan_kc' => $this->makeObject(
                "The Leviathan",
                RunescapeTypes::Killcount,
            ),
            'the_leviathan_pb' => $this->makeObject(
                "The Leviathan",
                RunescapeTypes::PersonalBest,
            ),
            'the_whisperer_kc' => $this->makeObject(
                "The Whisperer",
                RunescapeTypes::Killcount,
            ),
            'the_whisperer_pb' => $this->makeObject(
                "The Whisperer",
                RunescapeTypes::PersonalBest,
            ),
            'vardorvis_kc' => $this->makeObject(
                "Vardorvis",
                RunescapeTypes::Killcount,
            ),
            'vardorvis_pb' => $this->makeObject(
                "Vardorvis",
                RunescapeTypes::PersonalBest,
            ),
            'duke_sucellus_kc' => $this->makeObject(
                "Duke Sucellus",
                RunescapeTypes::Killcount,
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
        string $index = null,
    ): array {
        return [
            'text' => $text,
            'index' => $index ?? strtolower($text),
            'type' => $type,
        ];
    }
}
