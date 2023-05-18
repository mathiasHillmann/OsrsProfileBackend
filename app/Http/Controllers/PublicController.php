<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\RunescapeTypes;
use App\Models\Player;
use App\Services\QuestService;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends Controller
{
    public function __construct(
        private SkillService $skillService,
        private QuestService $questService,
    ) {
    }

    #[Route('/public/player/{accountHash}', methods: ['GET'])]
    public function load(Request $request, string $accountHash): JsonResponse
    {
        try {
            $default = $this->getDefaultValues($request);

            if ($player = Player::find($accountHash)) {
                $data = $player->data;

                // Include new objects to track that are not in the player data
                $data = array_merge($data, array_diff_key($default, $data));

                // Remove all keys from data which are not present on the default values
                // Used when someone changes the config of the plugin to not track X
                $data = array_intersect_key($data, $default);

                return Response::json($data);
            }

            return Response::json($default);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/public/player/{accountHash}', methods: ['POST'])]
    public function submit(Request $request, string $accountHash): JsonResponse
    {
        try {
            $player = Player::updateOrCreate([
                'account_hash' => $accountHash
            ], [
                'data' => $request->input('data'),
                'username' => $request->input('username'),
                'account_type' => $request->input('accountType'),
            ]);

            return $this->response($player);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
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
