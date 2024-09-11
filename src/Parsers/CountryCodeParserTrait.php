<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Parsers;

use Helip\PhoneNumber\Ressources\InternationalPrefixes;

trait CountryCodeParserTrait
{
    public static function calculateCountryCode(string $rawPhoneNumber): array
    {
        // No international prefix, no country code => unknown country
        if (substr($rawPhoneNumber, 0, 1) !== '+' && substr($rawPhoneNumber, 0, 2) !== '00') {
            return [
                'countryCode' => InternationalPrefixes::ERROR_UNKNOWN_COUNTRY,
                'internationalPrefix' => InternationalPrefixes::ERROR_UNKNOWN_COUNTRY,
                'localNumber' => ''
            ];
        }

        // remove initial +, if present
        $rawPhoneNumber = preg_replace('/\+/', '', $rawPhoneNumber);

        // remove initial 00, if present
        $rawPhoneNumber = preg_replace('/^00/', '', $rawPhoneNumber);

        // Try prefixes from longest to shortest
        $prefixLengths = [3, 2, 1];
        foreach ($prefixLengths as $length) {
            $prefix = self::tryCountryPrefix($rawPhoneNumber, $length);
            if ($prefix) {
                return $prefix;
            }
        }

        return [
            'countryCode' => InternationalPrefixes::ERROR_UNKNOWN_COUNTRY,
            'internationalPrefix' => InternationalPrefixes::ERROR_UNKNOWN_COUNTRY,
            'localNumber' => ''
        ];
    }

    private static function tryCountryPrefix(string $rawPhoneNumber, int $length): array|false
    {
        $internationalPrefix = substr($rawPhoneNumber, 0, $length);
        $countryCode = InternationalPrefixes::getCountryByPrefix($internationalPrefix);

        if ($countryCode['country'] !== InternationalPrefixes::ERROR_UNKNOWN_COUNTRY) {
            return [
                'countryCode' => $countryCode['countryCode'],
                'internationalPrefix' => $internationalPrefix,
                'localNumber' => substr($rawPhoneNumber, $length)
            ];
        }

        return false;
    }
}
