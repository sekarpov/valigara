<?php

declare(strict_types=1);

namespace App\FbaService;

class AddressParser
{
    private string $name;

    private string $addressLine;

    private string $city;

    private string $region;

    private string $postalCode;

    private string $country;

    private function __construct(string $name, string $addressLine, string $city, string $region, string $postalCode, string $country)
    {
        $this->name        = $name;
        $this->addressLine = $addressLine;
        $this->city        = $city;
        $this->region      = $region;
        $this->postalCode  = $postalCode;
        $this->country     = $country;
    }

    public static function fromString($address)
    {
        $addressParts = explode("\n", $address);

        $name        = $addressParts[0];
        $addressLine = $addressParts[1];
        $city        = $addressParts[2];
        $region      = $addressParts[3];

        $postalCodeCountryParts = explode(" ", trim($addressParts[4]));

        $postalCode = $postalCodeCountryParts[0];
        $country    = implode(" ", array_slice($postalCodeCountryParts, 1));

        return new self($name, $addressLine, $city, $region, $postalCode, $country);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): string
    {
        return $this->addressLine;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function region(): string
    {
        return $this->region;
    }

    public function postalCode(): string
    {
        return $this->postalCode;
    }

    public function country(): string
    {
        return $this->country;
    }
}
