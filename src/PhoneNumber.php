<?php

declare(strict_types=1);

namespace Helip\PhoneNumber;

use Helip\PhoneNumber\Models\PhoneNumberModel;
use Helip\PhoneNumber\Parsers\PhoneNumberParser;

class PhoneNumber
{
    private PhoneNumberModel $phoneNumberModel;

    /**
     * Create a new PhoneNumber object.
     *
     * @param string $rawPhoneNumber The phone number to parse.
     */
    public function __construct(string $rawPhoneNumber)
    {
        $this->phoneNumberModel = PhoneNumberParser::parse($rawPhoneNumber);
    }

    /**
     * Get the original unformatted phone number.
     */
    public function getRawFormat(): string
    {
        return $this->phoneNumberModel->getRawFormat();
    }

    /**
     * Get the phone number type.
     * Possible values: mobile, fixed
     */ 
    public function getType(): string
    {
        return $this->phoneNumberModel->getType();
    }

    /**
     * Get the ISO 3166-1 alpha-2 country code.
     */
    public function getCountryCode(): ?string
    {
        return $this->phoneNumberModel->getCountryCode();
    }

    /**
     * Get the international format of the phone number.
     * Example: +32 471 234 567
     */
    public function getInternationalFormat(): ?string
    {
        return $this->phoneNumberModel->getInternationalFormat();
    }

    /**
     * Get the international prefix of the phone number.
     * Example: 32
     */
    public function getInternationalPrefix(): ?string
    {
        return $this->phoneNumberModel->getInternationalPrefix();
    }
}
