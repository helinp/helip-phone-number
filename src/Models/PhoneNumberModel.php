<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Models;

use InvalidArgumentException;

class PhoneNumberModel
{
    public const TYPE_MOBILE = 'mobile';
    public const TYPE_FIXED = 'fixed';
    public const TYPE_UNKNOWN = 'unknown';

    public const VALID_TYPES = [self::TYPE_MOBILE, self::TYPE_FIXED];

    public function __construct(
        private string $rawFormat,
        private ?string $type,
        private ?string $countryCode,
        private ?string $internationalFormat,
        private ?string $internationalPrefix,
        private ?string $operatorOrZone,
        private ?string $localFormat
    ) {
    }

    public function getInternationalFormat(): ?string
    {
        return $this->internationalFormat;
    }

    public function getInternationalRaw(): ?string
    {
        return preg_replace('/\s/', '', $this->getInternationalFormat());
    }

    public function getInternationalPrefix(): ?string
    {
        return $this->internationalPrefix;
    }

    public function getRawFormat(): string
    {
        return $this->rawFormat;
    }

    public function getOperatorOrZone(): ?string
    {
        return $this->operatorOrZone;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getLocalFormat(): ?string
    {
        return $this->localFormat;
    }

    public function setRawFormat(string $rawFormat): void
    {
        $this->rawFormat = $rawFormat;
    }

    public function setType(string $type): void
    {
        if (!in_array($type, self::VALID_TYPES)) {
            throw new InvalidArgumentException('Invalid phone type. Allowed values: mobile, fixed.');
        }
        $this->type = $type;
    }

    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }
}
