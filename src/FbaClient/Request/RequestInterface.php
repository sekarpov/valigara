<?php

namespace App\FbaClient\Request;

interface RequestInterface
{
    public function normalize(): array;
}
