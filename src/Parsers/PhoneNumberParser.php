<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Parsers;

use Helip\PhoneNumber\Models\PhoneNumberModel;

/**
 * Parse a phone number and return a PhoneNumberModel object.
 */
class PhoneNumberParser
{
    use CountryCodeParserTrait;
    use TypeParserTrait;
    use FormatsParserTrait;

    public static function parse(string $rawPhoneNumber): PhoneNumberModel|null
    {
        // cleaning the phone number
        $rawPhoneNumber = preg_replace('/[^0-9+]/', '', $rawPhoneNumber);

        $countryCode = self::calculateCountryCode($rawPhoneNumber);
        $types = self::calculateType($rawPhoneNumber, $countryCode['internationalPrefix'], $countryCode['countryCode']);
        $type = $types['type'];
        $localPrefix = $types['localPrefix'];

        $formats = self::calculateFormats(
            rawPhoneNumber: $rawPhoneNumber,
            internationalPrefix: $countryCode['internationalPrefix'],
            countryCode: $countryCode['countryCode'],
            type: $type,
            localPrefix: $localPrefix
        );

        // constructing the phone number object
        return new PhoneNumberModel(
            rawFormat: $rawPhoneNumber,
            type: $type,
            countryCode: $countryCode['countryCode'],
            internationalFormat: $formats['internationalFormat'],
            internationalPrefix: $countryCode['internationalPrefix'],
            operatorOrZone: '', # not implemented yet
            localFormat: $formats['localFormat']
        );
    }
}
