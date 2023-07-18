<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AchievementDiaryRegion;
use App\Enums\AchievementDiaryTier;
use App\Enums\RunescapeTypes;

class AchievementDiaryService implements OsrsService
{
    public function translate(array &$data): void
    {
        $diaries = $this->getValuesToTrack();

        foreach ($diaries as $diary) {
            dd($diary);
        }
    }

    public function getValuesToTrack(): array
    {
        return [
            'ardougne_easy' => $this->makeObject(
                4458,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Ardougne,
                AchievementDiaryTier::Easy,
            ),
            'ardougne_medium' => $this->makeObject(
                4459,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Ardougne,
                AchievementDiaryTier::Medium,
            ),
            'ardougne_hard' => $this->makeObject(
                4460,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Ardougne,
                AchievementDiaryTier::Hard,
            ),
            'ardougne_elite' => $this->makeObject(
                4461,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Ardougne,
                AchievementDiaryTier::Elite,
            ),

            'desert_easy' => $this->makeObject(
                4483,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Desert,
                AchievementDiaryTier::Easy,
            ),
            'desert_medium' => $this->makeObject(
                4484,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Desert,
                AchievementDiaryTier::Medium,
            ),
            'desert_hard' => $this->makeObject(
                4485,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Desert,
                AchievementDiaryTier::Hard,
            ),
            'desert_elite' => $this->makeObject(
                4486,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Desert,
                AchievementDiaryTier::Elite,
            ),

            'falador_easy' => $this->makeObject(
                4462,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Falador,
                AchievementDiaryTier::Easy,
            ),
            'falador_medium' => $this->makeObject(
                4463,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Falador,
                AchievementDiaryTier::Medium,
            ),
            'falador_hard' => $this->makeObject(
                4464,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Falador,
                AchievementDiaryTier::Hard,
            ),
            'falador_elite' => $this->makeObject(
                4465,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Falador,
                AchievementDiaryTier::Elite,
            ),

            'fremennik_easy' => $this->makeObject(
                4491,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Fremennik,
                AchievementDiaryTier::Easy,
            ),
            'fremennik_medium' => $this->makeObject(
                4492,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Fremennik,
                AchievementDiaryTier::Medium,
            ),
            'fremennik_hard' => $this->makeObject(
                4493,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Fremennik,
                AchievementDiaryTier::Hard,
            ),
            'fremennik_elite' => $this->makeObject(
                4494,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Fremennik,
                AchievementDiaryTier::Elite,
            ),

            'kandarin_easy' => $this->makeObject(
                4475,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kandarin,
                AchievementDiaryTier::Easy,
            ),
            'kandarin_medium' => $this->makeObject(
                4476,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kandarin,
                AchievementDiaryTier::Medium,
            ),
            'kandarin_hard' => $this->makeObject(
                4477,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kandarin,
                AchievementDiaryTier::Hard,
            ),
            'kandarin_elite' => $this->makeObject(
                4478,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kandarin,
                AchievementDiaryTier::Elite,
            ),

            'karamja_easy' => $this->makeObject(
                3578,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Karamja,
                AchievementDiaryTier::Easy,
            ),
            'karamja_medium' => $this->makeObject(
                3599,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Karamja,
                AchievementDiaryTier::Medium,
            ),
            'karamja_hard' => $this->makeObject(
                3611,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Karamja,
                AchievementDiaryTier::Hard,
            ),
            'karamja_elite' => $this->makeObject(
                4566,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Karamja,
                AchievementDiaryTier::Elite,
            ),

            'kourend_easy' => $this->makeObject(
                7925,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kourend,
                AchievementDiaryTier::Easy,
            ),
            'kourend_medium' => $this->makeObject(
                7926,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kourend,
                AchievementDiaryTier::Medium,
            ),
            'kourend_hard' => $this->makeObject(
                7927,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kourend,
                AchievementDiaryTier::Hard,
            ),
            'kourend_elite' => $this->makeObject(
                7928,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Kourend,
                AchievementDiaryTier::Elite,
            ),

            'lumbridge_easy' => $this->makeObject(
                4495,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Lumbridge,
                AchievementDiaryTier::Easy,
            ),
            'lumbridge_medium' => $this->makeObject(
                4496,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Lumbridge,
                AchievementDiaryTier::Medium,
            ),
            'lumbridge_hard' => $this->makeObject(
                4497,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Lumbridge,
                AchievementDiaryTier::Hard,
            ),
            'lumbridge_elite' => $this->makeObject(
                4498,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Lumbridge,
                AchievementDiaryTier::Elite,
            ),

            'morytania_easy' => $this->makeObject(
                4487,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Morytania,
                AchievementDiaryTier::Easy,
            ),
            'morytania_medium' => $this->makeObject(
                4488,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Morytania,
                AchievementDiaryTier::Medium,
            ),
            'morytania_hard' => $this->makeObject(
                4489,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Morytania,
                AchievementDiaryTier::Hard,
            ),
            'morytania_elite' => $this->makeObject(
                4490,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Morytania,
                AchievementDiaryTier::Elite,
            ),

            'varrock_easy' => $this->makeObject(
                4479,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Varrock,
                AchievementDiaryTier::Easy,
            ),
            'varrock_medium' => $this->makeObject(
                4480,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Varrock,
                AchievementDiaryTier::Medium,
            ),
            'varrock_hard' => $this->makeObject(
                4481,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Varrock,
                AchievementDiaryTier::Hard,
            ),
            'varrock_elite' => $this->makeObject(
                4482,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Varrock,
                AchievementDiaryTier::Elite,
            ),

            'western_easy' => $this->makeObject(
                4471,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Western,
                AchievementDiaryTier::Easy,
            ),
            'western_medium' => $this->makeObject(
                4472,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Western,
                AchievementDiaryTier::Medium,
            ),
            'western_hard' => $this->makeObject(
                4473,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Western,
                AchievementDiaryTier::Hard,
            ),
            'western_elite' => $this->makeObject(
                4474,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Western,
                AchievementDiaryTier::Elite,
            ),

            'wilderness_easy' => $this->makeObject(
                4466,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Wilderness,
                AchievementDiaryTier::Easy,
            ),
            'wilderness_medium' => $this->makeObject(
                4467,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Wilderness,
                AchievementDiaryTier::Medium,
            ),
            'wilderness_hard' => $this->makeObject(
                4468,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Wilderness,
                AchievementDiaryTier::Hard,
            ),
            'wilderness_elite' => $this->makeObject(
                4469,
                RunescapeTypes::VarBit,
                AchievementDiaryRegion::Wilderness,
                AchievementDiaryTier::Elite,
            ),
        ];
    }

    private function makeObject(
        int $index,
        RunescapeTypes $type,
        AchievementDiaryRegion $region,
        AchievementDiaryTier $tier,
    ): array {
        return [
            'index' => $index,
            'type' => $type,
            'region' => $region,
            'tier' => $tier
        ];
    }
}
