<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\IncrementViewJob;
use App\Models\Player;
use App\Services\QuestService;
use App\Services\SkillService;
use App\Services\SummaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
                dispatch(new IncrementViewJob($username));

                $data = $player->data;
                $this->questService->translate($data);
                $this->skillService->translate($data);
                $this->summaryService->translate($data, $player);

                return $this->response($data);
            } else {
                return $this->response(null, HttpFoundationResponse::HTTP_BAD_REQUEST, 'Player not found');
            }
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/api/delete', methods: ['GET'])]
    public function delete(Request $request): JsonResponse
    {
        try {
            Mail::raw("Username: {$request->input('username')}", function (Message $m) {
                $m->subject('Profile removal request');
                $m->to('osrs.profile.dev@gmail.com');
            });
            return $this->response(message: 'OK');
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/api/search/{search}', methods: ['GET'])]
    public function search(Request $request, string $search): JsonResponse
    {
        try {
            $search = strtolower($search);
            $players = Player::where(DB::raw('lower(username)'), 'like', "%{$search}%")->orderByRaw('LENGTH(username), username')->get(['username'])->pluck('username');

            return $this->response($players);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/api/random', methods: ['GET'])]
    public function random(Request $request): JsonResponse
    {
        try {
            $player = DB::table('players')
                ->orderByRaw('RAND()')
                ->select('username')
                ->first();

            return $this->response($player);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    #[Route('/api/most-viewed', methods: ['GET'])]
    public function mostViewed(Request $request): JsonResponse
    {
        try {
            $players = DB::table('players')
                ->orderBy('views', 'DESC')
                ->select([DB::raw('ROW_NUMBER() OVER () AS `rank`'), 'username', 'views', 'account_type'])
                ->where('views', '>', 0)
                ->limit(100)
                ->get();

            return $this->response($players);
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }
}
