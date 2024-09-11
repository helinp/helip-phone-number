<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Parsers;

use Helip\PhoneNumber\Ressources\BelgianFormat;

trait FormatsParserTrait
{
    public static function calculateFormats(string $rawPhoneNumber, ?string $internationalPrefix, ?string $countryCode, ?string $type, ?string $localPrefix): array
    {
        if (!$internationalPrefix) {
            return [
                'internationalFormat' => null,
                'localFormat' => null
            ];
        }

        // removes international prefix, if any
        $rawPhoneNumber = preg_replace('/\+' . $internationalPrefix . '/', '', $rawPhoneNumber);
        $rawPhoneNumber = preg_replace('/^00' . $internationalPrefix . '/', '', $rawPhoneNumber);

        // add leading zero if necessary
        if (substr($rawPhoneNumber, 0, 1) !== '0') {
            $rawPhoneNumber = '0' . $rawPhoneNumber;
        }

        // NOTE: Only Belgium is supported for now
        // add more countries and specific classes
        // and ensure dynamic class loading
        $localFormat = null;
        switch ($countryCode) {
            case 'BE':
                $localFormat = BelgianFormat::format($rawPhoneNumber, $type, $localPrefix);
                break;
        }

        return [
            'internationalFormat' => self::formatInternational($localFormat, $internationalPrefix),
            'localFormat' => $localFormat
        ];
    }

    private static function formatInternational(?string $localFormat, ?string $internationalPrefix): string
    {
        if (!$internationalPrefix || !$localFormat) {
            return '';
        }

        // remove leading zero if necessary
        if (substr($localFormat, 0, 1) === '0') {
            $localFormat = substr($localFormat, 1);
        }

        return '+' . $internationalPrefix . ' ' . $localFormat;
    }
}
