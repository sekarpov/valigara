<?php

declare(strict_types=1);

namespace App\FbaClient;

class Config
{
    public function __construct(
        public string $baseUri,
        public string $token,
        public float $connectTimeout
    ) {
    }
}
