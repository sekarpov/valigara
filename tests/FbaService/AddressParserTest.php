<?php

namespace FbaService;

use App\FbaService\AddressParser;
use PHPUnit\Framework\TestCase;

class AddressParserTest extends TestCase
{
    public function testSuccess(): void
    {
        $address = AddressParser::fromString("Firstname Lastname\n12 Test Rd\nLock Haven\nPA\n17745 United States\n\n");

        $this->assertEquals('Firstname Lastname', $address->name());
        $this->assertEquals('12 Test Rd', $address->address());
        $this->assertEquals('Lock Haven', $address->city());
        $this->assertEquals('PA', $address->region());
        $this->assertEquals('17745', $address->postalCode());
        $this->assertEquals('United States', $address->country());
    }
}
