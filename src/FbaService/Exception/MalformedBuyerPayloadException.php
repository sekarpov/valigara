<?php

declare(strict_types=1);

namespace App\FbaService\Exception;

use Exception;

class MalformedBuyerPayloadException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Buyer payload must have [%s] element, but [%s] given.';

    public function __construct(string $elemName, string $given)
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $elemName, $given);

        parent::__construct($message);
    }
}
