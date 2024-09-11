<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Ressources;

class InternationalPrefixes
{
    public const ERROR_UNKNOWN_COUNTRY = 'Unknown country';

    private const WESTERN_EUROPE = [
        '32'  => ['countryCode' => 'BE', 'country' => 'Belgium'],
        '33'  => ['countryCode' => 'FR', 'country' => 'France'],
        '49'  => ['countryCode' => 'DE', 'country' => 'Germany'],
        '31'  => ['countryCode' => 'NL', 'country' => 'Netherlands'],
        '41'  => ['countryCode' => 'CH', 'country' => 'Switzerland'],
        '43'  => ['countryCode' => 'AT', 'country' => 'Austria'],
        '44'  => ['countryCode' => 'GB', 'country' => 'United Kingdom'],
        '352' => ['countryCode' => 'LU', 'country' => 'Luxembourg'],
        '423' => ['countryCode' => 'LI', 'country' => 'Liechtenstein'],
        '353' => ['countryCode' => 'IE', 'country' => 'Ireland']
    ];

    /**
     * Get the country code and country name for a given international prefix.
     *
     * @param string $prefix The international prefix to get the country code and country name for.
     * @return array The country code and country name for the given international prefix.
     */
    public static function getCountryByPrefix(string $prefix): array
    {
        if (array_key_exists($prefix, self::WESTERN_EUROPE)) {
            return self::WESTERN_EUROPE[$prefix];
        }

        return [
            'countryCode' => InternationalPrefixes::ERROR_UNKNOWN_COUNTRY,
            'country' => InternationalPrefixes::ERROR_UNKNOWN_COUNTRY
        ];
    }

    /**
     * Fin prefixes for the given country code.
     *
     * @param string $countryCode The country code to get the international prefixes for.
     * @return array The international prefixes for the given country code. 
     */
    public static function getPrefixeByCountryCode(string $countryCode): string
    {
        foreach (self::WESTERN_EUROPE as $prefix => $country) {
            if ($country['countryCode'] === $countryCode) {
                return (string) $prefix;
            }
        }

        return InternationalPrefixes::ERROR_UNKNOWN_COUNTRY;
    }
}
