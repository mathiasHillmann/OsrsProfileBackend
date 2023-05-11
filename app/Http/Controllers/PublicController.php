<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\RunescapeTypes;
use App\Services\QuestService;
use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function __construct(
        private SkillService $skillService,
        private QuestService $questService,
    ) {
    }

    public function load(Request $request, string $accountHash): JsonResponse
    {
        try {
            return $this->response($this->getDefaultValues());
        } catch (\Throwable $th) {
            return $this->response($th);
        }
    }

    private function getDefaultValues(): array
    {
        $values = [
            ...$this->skillService->getValuesToTrack(),
            ...$this->questService->getValuesToTrack(),
        ];

        // Filter all keys of a value to track to only index, type and value
        array_walk($values, function (&$value) {
            $value = [
                'index' => $value['index'],
                'type' => $value['type'],
                'value' => null,
            ];
        });

        return $values;
    }

    private function makeTrackingObject(string $index, RunescapeTypes $type): array
    {
        return [
            'index' => $index,
            'type' => $type->value,
            'value' => null,
        ];
    }
}
