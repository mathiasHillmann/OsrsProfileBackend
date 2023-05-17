<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\RunescapeTypes;
use App\Models\Player;
use App\Services\QuestService;
use App\Services\SkillService;
use App\Services\SummaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends Controller
{
    public function __construct(
        private SkillService $skillService,
        private QuestService $questService,
        private SummaryService $summaryService,
    ) {
    }

    #[Route('/api/player/{username}', methods: ['GET'])]
    public function load(Request $request, string $username): JsonResponse
    {
        try {
            if ($player = Player::where('username', $username)->first()) {
                $data = $player->data;

                $this->questService->translate($data);
                $this->skillService->translate($data);
                $this->summaryService->translate($data, $player->updated_at);

                return $this->response($data);
            } else {
                return $this->response(null, HttpFoundationResponse::HTTP_BAD_REQUEST, 'Player not found');
            }
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/api/search/{search}', methods: ['GET'])]
    public function search(Request $request, string $search): JsonResponse
    {
        try {
            $search = strtolower($search);
            $players = Player::where(DB::raw('lower(username)'), 'like', "%{$search}%")->get(['username'])->pluck('username');

            return $this->response($players);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }
}
