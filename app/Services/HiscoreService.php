<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RunescapeAccountTypes;
use App\Models\Player;
use Illuminate\Support\Facades\Http;

class HiscoreService
{
    private function getHiscoresEndpoint(RunescapeAccountTypes $accountType): string
    {
        $type = match ($accountType) {
            RunescapeAccountTypes::Ironman => 'hiscore_oldschool_ironman',
            RunescapeAccountTypes::HardcoreIronman => 'hiscore_oldschool_hardcore_ironman',
            RunescapeAccountTypes::UltimateIronman => 'hiscore_oldschool_ultimate',
            default => 'hiscore_oldschool',
        };

        return "https://services.runescape.com/m={$type}/index_lite.json";
    }

    public function fetchPlayer(Player $player): array
    {
        $response = Http::get($this->getHiscoresEndpoint($player->account_type), ['player' => $player->username]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [];
        }
    }
}
