<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeQuestStatus;
use App\Enums\RunescapeQuestTypes;
use App\Enums\RunescapeTypes;

class QuestService implements TranslatingInterface
{
    public function getValuesToTrack(): array
    {
        return [
            ...$this->getVarpQuests(),
            ...$this->getVarbQuests(),
        ];
    }

    public function translate(array &$data): void
    {
        $quests = $this->getValuesToTrack();

        foreach ($quests as $questName => $quest) {
            $item = $data[$questName];
            if (!$item) {
                $data[$quest['questType']->value][$questName] = RunescapeQuestStatus::Unknown;
            }

            if (!$item['value'] || $item['value'] <= $quest['startValue']) {
                $data[$quest['questType']->value][$questName] = RunescapeQuestStatus::NotStarted;
            } elseif ($item['value'] >= $quest['endValue']) {
                $data[$quest['questType']->value][$questName] = RunescapeQuestStatus::Complete;
            } else {
                $data[$quest['questType']->value][$questName] = RunescapeQuestStatus::InProgress;
            }

            unset($data[$questName]);
        }
    }

    private function getVarbQuests(): array
    {
        return [
            'a_kingdom_divided' => $this->makeObject(12296, RunescapeTypes::VarBit, 0, 150),
            'a_night_at_the_theatre' => $this->makeObject(12276, RunescapeTypes::VarBit, 0, 86),
            'a_porcine_of_interest' => $this->makeObject(10582, RunescapeTypes::VarBit, 0, 40),
            'a_souls_bane' => $this->makeObject(2011, RunescapeTypes::VarBit, 0, 13),
            'a_tail_of_two_cats' => $this->makeObject(1028, RunescapeTypes::VarBit, 0, 70),
            'a_taste_of_hope' => $this->makeObject(6396, RunescapeTypes::VarBit, 0, 165),
            'alfred_grimhand_barcrawl' => $this->makeObject(13714, RunescapeTypes::VarBit, 0, 2, RunescapeQuestTypes::Miniquest),
            'animal_magnetism' => $this->makeObject(3185, RunescapeTypes::VarBit, 0, 240),
            'another_slice_of_ham' => $this->makeObject(3550, RunescapeTypes::VarBit, 0, 11),
            'architectural_alliance' => $this->makeObject(13784, RunescapeTypes::VarBit, 0, 3, RunescapeQuestTypes::Miniquest),
            'bear_your_soul' => $this->makeObject(5078, RunescapeTypes::VarBit, 0, 3, RunescapeQuestTypes::Miniquest),
            'below_ice_mountain' => $this->makeObject(12063, RunescapeTypes::VarBit, 0, 120),
            'beneath_cursed_sands' => $this->makeObject(13841, RunescapeTypes::VarBit, 0, 108),
            'between_a_rock' => $this->makeObject(299, RunescapeTypes::VarBit, 0, 110),
            'bone_voyage' => $this->makeObject(5795, RunescapeTypes::VarBit, 0, 50),
            'client_of_kourend' => $this->makeObject(5619, RunescapeTypes::VarBit, 0, 7),
            'cold_war' => $this->makeObject(3293, RunescapeTypes::VarBit, 0, 135),
            'contact' => $this->makeObject(3274, RunescapeTypes::VarBit, 0, 130),
            'creature_of_fenkenstrain' => $this->makeObject(13715, RunescapeTypes::VarBit, 0, 9),
            'curse_of_the_empty_lord' => $this->makeObject(13713, RunescapeTypes::VarBit, 0, 6, RunescapeQuestTypes::Miniquest),
            'daddys_home' => $this->makeObject(10570, RunescapeTypes::VarBit, 0, 13, RunescapeQuestTypes::Miniquest),
            'darkness_of_hallowvale' => $this->makeObject(2573, RunescapeTypes::VarBit, 0, 320),
            'death_to_the_dorgeshuun' => $this->makeObject(2258, RunescapeTypes::VarBit, 0, 13),
            'demon_slayer' => $this->makeObject(2561, RunescapeTypes::VarBit, 0, 3),
            'desert_treasure_1' => $this->makeObject(358, RunescapeTypes::VarBit, 0, 15),
            'devious_minds' => $this->makeObject(1465, RunescapeTypes::VarBit, 0, 80),
            'dragon_slayer_2' => $this->makeObject(6104, RunescapeTypes::VarBit, 0, 215),
            'dream_mentor' => $this->makeObject(3618, RunescapeTypes::VarBit, 0, 28),
            'eagles_peak' => $this->makeObject(2780, RunescapeTypes::VarBit, 0, 40),
            'elemental_workshop_1' => $this->makeObject(13718, RunescapeTypes::VarBit, 0, 2),
            'elemental_workshop_2' => $this->makeObject(2639, RunescapeTypes::VarBit, 0, 11),
            'enakhras_lament' => $this->makeObject(1560, RunescapeTypes::VarBit, 0, 70),
            'enlightened_journey' => $this->makeObject(2866, RunescapeTypes::VarBit, 0, 200),
            'fairytale_1_growing_pains' => $this->makeObject(1803, RunescapeTypes::VarBit, 0, 90),
            'fairytale_2_cure_a_queen' => $this->makeObject(2326, RunescapeTypes::VarBit, 10, 90),
            'family_pest' => $this->makeObject(5347, RunescapeTypes::VarBit, 0, 3, RunescapeQuestTypes::Miniquest),
            'forgettable_tale' => $this->makeObject(822, RunescapeTypes::VarBit, 0, 140),
            'gardenn_of_tranquillity' => $this->makeObject(961, RunescapeTypes::VarBit, 0, 60),
            'getting_ahead' => $this->makeObject(693, RunescapeTypes::VarBit, 0, 34),
            'ghosts_ahoy' => $this->makeObject(217, RunescapeTypes::VarBit, 0, 8),
            'goblin_diplomacy' => $this->makeObject(2378, RunescapeTypes::VarBit, 0, 6),
            'grim_tales' => $this->makeObject(2783, RunescapeTypes::VarBit, 0, 60),
            'hopespears_will' => $this->makeObject(13619, RunescapeTypes::VarBit, 0, 2, RunescapeQuestTypes::Miniquest),
            'horror_from_the_deep' => $this->makeObject(34, RunescapeTypes::VarBit, 0, 10),
            'icthlarins_little_helper' => $this->makeObject(418, RunescapeTypes::VarBit, 0, 26),
            'in_aid_of_the_myreque' => $this->makeObject(1990, RunescapeTypes::VarBit, 0, 430),
            'in_search_of_knowledge' => $this->makeObject(8403, RunescapeTypes::VarBit, 0, 3, RunescapeQuestTypes::Miniquest),
            'into_the_tombs' => $this->makeObject(13836, RunescapeTypes::VarBit, 0, 24, RunescapeQuestTypes::Miniquest),
            'kings_ransom' => $this->makeObject(3888, RunescapeTypes::VarBit, 0, 90),
            'lair_of_tarn_razorlor' => $this->makeObject(3290, RunescapeTypes::VarBit, 0, 3, RunescapeQuestTypes::Miniquest),
            'land_of_the_goblins' => $this->makeObject(13599, RunescapeTypes::VarBit, 0, 56),
            'lunar_diplomacy' => $this->makeObject(2448, RunescapeTypes::VarBit, 0, 190),
            'mage_arena_2' => $this->makeObject(6067, RunescapeTypes::VarBit, 0, 4, RunescapeQuestTypes::Miniquest),
            'making_friends_with_my_arm' => $this->makeObject(6528, RunescapeTypes::VarBit, 0, 200),
            'making_history' => $this->makeObject(1383, RunescapeTypes::VarBit, 0, 4),
            'misthalin_mystery' => $this->makeObject(1383, RunescapeTypes::VarBit, 0, 4),
            'monkey_madness_2' => $this->makeObject(5027, RunescapeTypes::VarBit, 0, 195),
            'mountain_daughter' => $this->makeObject(260, RunescapeTypes::VarBit, 0, 70),
            'mournings_end_part_2' => $this->makeObject(1103, RunescapeTypes::VarBit, 0, 60),
            'my_arms_big_adventure' => $this->makeObject(2790, RunescapeTypes::VarBit, 0, 320),
            'olafs_quest' => $this->makeObject(3534, RunescapeTypes::VarBit, 0, 80),
            'ratcatchers' => $this->makeObject(1404, RunescapeTypes::VarBit, 0, 127),
            'recipe_for_disaster' => $this->makeObject(1850, RunescapeTypes::VarBit, 0, 5),
            'recruitment_drive' => $this->makeObject(657, RunescapeTypes::VarBit, 0, 2),
            'royal_trouble' => $this->makeObject(2140, RunescapeTypes::VarBit, 0, 30),
            'secrets_of_the_north' => $this->makeObject(14722, RunescapeTypes::VarBit, 0, 90),
            'shadow_of_the_storm' => $this->makeObject(1372, RunescapeTypes::VarBit, 0, 125),
            'shield_of_arrav' => $this->makeObject(13716, RunescapeTypes::VarBit, 0, 2),
            'sins_of_the_father' => $this->makeObject(7255, RunescapeTypes::VarBit, 0, 138),
            'skippy_and_the_mogres' => $this->makeObject(1344, RunescapeTypes::VarBit, 0, 3, RunescapeQuestTypes::Miniquest),
            'sleeping_giants' => $this->makeObject(13902, RunescapeTypes::VarBit, 0, 30),
            'song_of_the_elves' => $this->makeObject(9016, RunescapeTypes::VarBit, 0, 200),
            'spirits_of_the_ellid' => $this->makeObject(1444, RunescapeTypes::VarBit, 0, 60),
            'swam_song' => $this->makeObject(2098, RunescapeTypes::VarBit, 0, 200),
            'tale_of_the_righteous' => $this->makeObject(6358, RunescapeTypes::VarBit, 0, 17),
            'tears_of_guthix' => $this->makeObject(451, RunescapeTypes::VarBit, 0, 2),
            'temple_of_the_eye' => $this->makeObject(13738, RunescapeTypes::VarBit, 0, 130),
            'the_ascent_of_aceuus' => $this->makeObject(7856, RunescapeTypes::VarBit, 0, 14),
            'the_corsair_curse' => $this->makeObject(6071, RunescapeTypes::VarBit, 0, 60),
            'the_depths_of_despair' => $this->makeObject(6027, RunescapeTypes::VarBit, 0, 11),
            'the_enchanted_key' => $this->makeObject(13717, RunescapeTypes::VarBit, 0, 2, RunescapeQuestTypes::Miniquest),
            'the_eyes_of_glouphrie' => $this->makeObject(2497, RunescapeTypes::VarBit, 0, 60),
            'the_feud' => $this->makeObject(334, RunescapeTypes::VarBit, 0, 28),
            'the_forsaken_tower' => $this->makeObject(7796, RunescapeTypes::VarBit, 0, 11),
            'the_fremennik_exiles' => $this->makeObject(9459, RunescapeTypes::VarBit, 0, 130),
            'the_freminnik_isles' => $this->makeObject(3311, RunescapeTypes::VarBit, 0, 340),
            'the_frozen_door' => $this->makeObject(13175, RunescapeTypes::VarBit, 0, 10, RunescapeQuestTypes::Miniquest),
            'the_garden_of_death' => $this->makeObject(14609, RunescapeTypes::VarBit, 0, 56),
            'the_generals_shadow' => $this->makeObject(3330, RunescapeTypes::VarBit, 0, 30, RunescapeQuestTypes::Miniquest),
            'the_giant_dwarf' => $this->makeObject(571, RunescapeTypes::VarBit, 0, 50),
            'the_golem' => $this->makeObject(346, RunescapeTypes::VarBit, 0, 10),
            'the_hand_in_the_sand' => $this->makeObject(1527, RunescapeTypes::VarBit, 0, 160),
            'the_lost_tribe' => $this->makeObject(532, RunescapeTypes::VarBit, 0, 11),
            'the_queen_of_thieves' => $this->makeObject(6037, RunescapeTypes::VarBit, 0, 13),
            'the_slug_menace' => $this->makeObject(2610, RunescapeTypes::VarBit, 0, 14),
            'tower_of_life' => $this->makeObject(3337, RunescapeTypes::VarBit, 0, 18),
            'wanted' => $this->makeObject(1051, RunescapeTypes::VarBit, 0, 11),
            'what_lies_below' => $this->makeObject(3523, RunescapeTypes::VarBit, 0, 150),
            'x_marks_the_spot' => $this->makeObject(8063, RunescapeTypes::VarBit, 0, 8),
            'zogre_flesh_eaters' => $this->makeObject(487, RunescapeTypes::VarBit, 0, 11),
        ];
    }

    private function getVarpQuests(): array
    {
        return [
            'big_chompy_bird_hunting' => $this->makeObject(293, RunescapeTypes::VarPlayer, 0, 65),
            'biohazard' => $this->makeObject(68, RunescapeTypes::VarPlayer, 0, 16),
            'black_knight_fortress' => $this->makeObject(130, RunescapeTypes::VarPlayer, 0, 4),
            'cabin_fever' => $this->makeObject(655, RunescapeTypes::VarPlayer, 0, 140),
            'clock_tower' => $this->makeObject(10, RunescapeTypes::VarPlayer, 0, 8),
            'cooks_assistant' => $this->makeObject(29, RunescapeTypes::VarPlayer, 0, 2),
            'death_plateau' => $this->makeObject(314, RunescapeTypes::VarPlayer, 0, 80),
            'dorics_quest' => $this->makeObject(31, RunescapeTypes::VarPlayer, 0, 100),
            'dragon_slayer_1' => $this->makeObject(176, RunescapeTypes::VarPlayer, 0, 10),
            'druidic_ritual' => $this->makeObject(80, RunescapeTypes::VarPlayer, 0, 4),
            'dwarf_cannon' => $this->makeObject(0, RunescapeTypes::VarPlayer, 0, 11),
            'eadgars_ruse' => $this->makeObject(335, RunescapeTypes::VarPlayer, 0, 110),
            'enter_the_abyss' => $this->makeObject(492, RunescapeTypes::VarPlayer, 0, 4, RunescapeQuestTypes::Miniquest),
            'ernest_the_chicken' => $this->makeObject(148, RunescapeTypes::VarPlayer, 0, 11),
            'family_crest' => $this->makeObject(148, RunescapeTypes::VarPlayer, 0, 11),
            'fight_arena' => $this->makeObject(17, RunescapeTypes::VarPlayer, 0, 14),
            'fishing_contest' => $this->makeObject(11, RunescapeTypes::VarPlayer, 0, 5),
            'gertrudes_cat' => $this->makeObject(180, RunescapeTypes::VarPlayer, 0, 6),
            'haunted_mine' => $this->makeObject(382, RunescapeTypes::VarPlayer, 0, 11),
            'hazeel_cult' => $this->makeObject(223, RunescapeTypes::VarPlayer, 0, 9),
            'heroes_quest' => $this->makeObject(188, RunescapeTypes::VarPlayer, 0, 15),
            'holy_grail' => $this->makeObject(5, RunescapeTypes::VarPlayer, 0, 10),
            'imp_catcher' => $this->makeObject(160, RunescapeTypes::VarPlayer, 0, 2),
            'in_search_of_the_myreque' => $this->makeObject(387, RunescapeTypes::VarPlayer, 0, 105),
            'jungle_potion' => $this->makeObject(175, RunescapeTypes::VarPlayer, 0, 12),
            'legends_quest' => $this->makeObject(139, RunescapeTypes::VarPlayer, 0, 75),
            'lost_city' => $this->makeObject(147, RunescapeTypes::VarPlayer, 0, 6),
            'mage_arena_1' => $this->makeObject(267, RunescapeTypes::VarPlayer, 0, 8, RunescapeQuestTypes::Miniquest),
            'merlins_crystal' => $this->makeObject(14, RunescapeTypes::VarPlayer, 0, 7),
            'monks_friend' => $this->makeObject(30, RunescapeTypes::VarPlayer, 0, 80),
            'monkey_madness_1' => $this->makeObject(365, RunescapeTypes::VarPlayer, 0, 9),
            'mournings_end_part_1' => $this->makeObject(517, RunescapeTypes::VarPlayer, 0, 9),
            'murder_mystery' => $this->makeObject(192, RunescapeTypes::VarPlayer, 0, 2),
            'nature_spirit' => $this->makeObject(307, RunescapeTypes::VarPlayer, 0, 110),
            'observatory_quest' => $this->makeObject(112, RunescapeTypes::VarPlayer, 0, 7),
            'one_small_favour' => $this->makeObject(416, RunescapeTypes::VarPlayer, 0, 285),
            'pirates_treasure' => $this->makeObject(71, RunescapeTypes::VarPlayer, 0, 4),
            'plague_city' => $this->makeObject(165, RunescapeTypes::VarPlayer, 0, 29),
            'priest_in_peril' => $this->makeObject(302, RunescapeTypes::VarPlayer, 0, 60),
            'prince_ali_rescue' => $this->makeObject(273, RunescapeTypes::VarPlayer, 0, 110),
            'rag_and_bone_man_1' => $this->makeObject(714, RunescapeTypes::VarPlayer, 0, 4),
            'rag_and_bone_man_2' => $this->makeObject(714, RunescapeTypes::VarPlayer, 3, 6),
            'regicide' => $this->makeObject(328, RunescapeTypes::VarPlayer, 0, 15),
            'romeo_and_juliet' => $this->makeObject(144, RunescapeTypes::VarPlayer, 0, 100),
            'roving_elves' => $this->makeObject(402, RunescapeTypes::VarPlayer, 0, 6),
            'rum_deal' => $this->makeObject(600, RunescapeTypes::VarPlayer, 0, 19),
            'rune_mysteries' => $this->makeObject(63, RunescapeTypes::VarPlayer, 0, 6),
            'scorpion_catcher' => $this->makeObject(76, RunescapeTypes::VarPlayer, 0, 6),
            'sea_slug' => $this->makeObject(159, RunescapeTypes::VarPlayer, 0, 12),
            'shades_of_mortton' => $this->makeObject(339, RunescapeTypes::VarPlayer, 0, 85),
            'sheep_herder' => $this->makeObject(60, RunescapeTypes::VarPlayer, 0, 3),
            'shilo_village' => $this->makeObject(116, RunescapeTypes::VarPlayer, 0, 15),
            'tai_bwo_wannai_trio' => $this->makeObject(320, RunescapeTypes::VarPlayer, 2, 6),
            'temple_of_ikov' => $this->makeObject(26, RunescapeTypes::VarPlayer, 0, 80),
            'the_digsite' => $this->makeObject(131, RunescapeTypes::VarPlayer, 0, 9),
            'the_fremennik_trials' => $this->makeObject(347, RunescapeTypes::VarPlayer, 0, 10),
            'the_grand_tree' => $this->makeObject(150, RunescapeTypes::VarPlayer, 0, 160),
            'the_great_brain_robbery' => $this->makeObject(980, RunescapeTypes::VarPlayer, 0, 130),
            'the_knights_sword' => $this->makeObject(122, RunescapeTypes::VarPlayer, 0, 7),
            'the_restless_ghost' => $this->makeObject(107, RunescapeTypes::VarPlayer, 0, 5),
            'the_tourist_trap' => $this->makeObject(197, RunescapeTypes::VarPlayer, 0, 30),
            'throne_of_miscellania' => $this->makeObject(359, RunescapeTypes::VarPlayer, 0, 100),
            'tree_gnome_village' => $this->makeObject(111, RunescapeTypes::VarPlayer, 0, 9),
            'tribal_totem' => $this->makeObject(200, RunescapeTypes::VarPlayer, 0, 5),
            'troll_romance' => $this->makeObject(385, RunescapeTypes::VarPlayer, 0, 45),
            'troll_stronghold' => $this->makeObject(317, RunescapeTypes::VarPlayer, 0, 50),
            'underground_pass' => $this->makeObject(161, RunescapeTypes::VarPlayer, 0, 11),
            'vampyre_slayer' => $this->makeObject(178, RunescapeTypes::VarPlayer, 0, 3),
            'watchtower' => $this->makeObject(212, RunescapeTypes::VarPlayer, 0, 13),
            'waterfall_quest' => $this->makeObject(65, RunescapeTypes::VarPlayer, 0, 10),
            'witchs_house' => $this->makeObject(226, RunescapeTypes::VarPlayer, 0, 7),
            'witchs_potion' => $this->makeObject(67, RunescapeTypes::VarPlayer, 0, 3),
        ];
    }

    private function makeObject(int $index, RunescapeTypes $type, int $startValue, int $endValue, RunescapeQuestTypes $questType = RunescapeQuestTypes::Quest): array
    {
        return [
            'index' => $index,
            'type' => $type,
            'questType' => $questType,
            'startValue' => $startValue,
            'endValue' => $endValue,
        ];
    }
}
