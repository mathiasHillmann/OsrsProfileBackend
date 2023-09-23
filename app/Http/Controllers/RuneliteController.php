<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RuneliteSubmitRequest;
use App\Models\Player;
use App\Services\AchievementDiaryService;
use App\Services\BossService;
use App\Services\CombatTaskService;
use App\Services\MinigameService;
use App\Services\QuestService;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Routing\Annotation\Route;

class RuneliteController extends Controller
{
    public function __construct(
        private SkillService $skillService,
        private QuestService $questService,
        private AchievementDiaryService $achievementDiaryService,
        private BossService $bossService,
        private MinigameService $minigameService,
        private CombatTaskService $combatTaskService,
    ) {
    }

    #[Route('/runelite/player/{accountHash}', methods: ['GET'])]
    public function load(Request $request, string $accountHash): JsonResponse
    {
        try {
            $default = $this->getDefaultValues($request);

            return Response::json($default);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/runelite/player/{accountHash}', methods: ['POST'])]
    public function submit(RuneliteSubmitRequest $request, string $accountHash): JsonResponse
    {
        try {
            $player = Player::find($accountHash);

            $data = $this->formatPlayerData($request->input('data'), $player);

            if ($player) {
                $player->update([
                    'data' => $data,
                    'username' => $request->input('username'),
                    'account_type' => $request->input('accountType'),
                ]);
            } else {
                $player = Player::create([
                    'account_hash' => $accountHash,
                    'data' => $data,
                    'username' => $request->input('username'),
                    'account_type' => $request->input('accountType'),
                ]);
            }

            return $this->response($player);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    private function formatPlayerData(array $data, Player $player = null): array
    {
        $return = [];

        $playerData = [];
        if ($player) {
            $playerData = $player->data;
        }

        foreach ($data as $key => $value) {
            // We want to check if the value exists in the player data and use it in case the supplied value is null
            // This is because a player could reinstall runelite and lose the stored in memory value of their kcs and personal bests
            // Which would wipe when sent to the server
            if ($value['value'] == null && array_key_exists($key, $playerData)) {
                if ($playerData[$key] != $value['value']) {
                    $value['value'] = $playerData[$key];
                }
            }

            $return[$key] = $value['value'];
        }

        return $return;
    }

    private function getDefaultValues(Request $request): array
    {
        $values = [];

        if ($request->boolean('skills')) {
            $values = array_merge($values, $this->skillService->getValuesToTrack());
        }

        if ($request->boolean('quests')) {
            $values = array_merge($values, $this->questService->getValuesToTrack());
        }

        if ($request->boolean('diaries')) {
            $values = array_merge($values, $this->achievementDiaryService->getValuesToTrack());
        }

        if ($request->boolean('bosskills')) {
            $values = array_merge($values, $this->bossService->getValuesToTrack());
        }

        if ($request->boolean('minigames')) {
            $values = array_merge($values, $this->minigameService->getValuesToTrack());
        }

        if ($request->boolean('combat')) {
            $values = array_merge($values, $this->combatTaskService->getValuesToTrack());
        }

        if (count($values) > 0) {
            // Filter all keys of a value to track to only index, type and value
            array_walk($values, function (&$value) {
                $value = [
                    'index' => $value['index'],
                    'type' => $value['type'],
                    'value' => null,
                ];
            });
        }

        return $values;
    }
}
