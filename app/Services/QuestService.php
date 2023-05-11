<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeTypes;

class QuestService
{
    public function getValuesToTrack(): array
    {
        return [
            ...$this->getVarpQuests(),
            ...$this->getVarbQuests(),
        ];
    }

    private function getVarbQuests(): array
    {
        return [
            'a_kingdom_divided' => $this->makeObject(12296, RunescapeTypes::VarBit, 0, 150),
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
            'enter_the_abyss' => $this->makeObject(492, RunescapeTypes::VarPlayer, 0, 4),
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
            'mage_arena_1' => $this->makeObject(267, RunescapeTypes::VarPlayer, 0, 8),
            'merlins_crystal' => $this->makeObject(14, RunescapeTypes::VarPlayer, 0, 7),
            'monks_friend' => $this->makeObject(30, RunescapeTypes::VarPlayer, 0, 80),
            'monkey_madness_1' => $this->makeObject(365, RunescapeTypes::VarPlayer, 0, 9),
            'mournings_end_part_1' => $this->makeObject(517, RunescapeTypes::VarPlayer, 0, 9),
            'murder_mystery' => $this->makeObject(192, RunescapeTypes::VarPlayer, 0, 2),
            'nature_spirit' => $this->makeObject(2, RunescapeTypes::VarPlayer, 0, 110),
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

    private function makeObject(int $index, RunescapeTypes $type, int $startValue, int $endValue): array
    {
        return [
            'index' => $index,
            'type' => $type->value,
            'startValue' => $startValue,
            'endValue' => $endValue,
        ];
    }
}
