<?php

declare(strict_types=1);

namespace App\FbaClient\Exception;

use Exception;

class FbaHttpException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Error [%s]. Response: [%s]. StatusCode: [%s]';

    public function __construct(string $message, string $response, int $code)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $message, $response, $code), $code);
    }
}
