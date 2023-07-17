<?php

declare(strict_types=1);

namespace App\Services;

interface OsrsService
{
    public function translate(array &$data): void;

    public function getValuesToTrack(): array;
}
