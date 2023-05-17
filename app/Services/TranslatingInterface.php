<?php

declare(strict_types=1);

namespace App\Services;

interface TranslatingInterface
{
    public function translate(array &$data): void;
}
