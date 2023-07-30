<?php

declare(strict_types=1);

namespace App\FbaClient\Exception;

use Exception;

class MalformedResponseException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Response must have [%s] element, but [%s] given.';

    public function __construct(string $elemName, string $givenResponse)
    {
        $message = sprintf(self::MESSAGE_TEMPLATE, $elemName, $givenResponse);

        parent::__construct($message);
    }
}
