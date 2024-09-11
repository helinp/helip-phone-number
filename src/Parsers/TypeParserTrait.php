<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Parsers;

use Helip\PhoneNumber\Models\PhoneNumberModel;
use Helip\PhoneNumber\Ressources\BelgianPrefixes;

trait TypeParserTrait
{
    // Mobile - Fixe
    public static function calculateType(string $rawPhoneNumber, string $internationalPrefix = '', string $countryCode = ''): array
    {
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
        switch ($countryCode) {
            case 'BE':
                return self::calculateTypeBelgium($rawPhoneNumber);
        }

        return [
            'type' => PhoneNumberModel::TYPE_UNKNOWN,
            'localPrefix' => ''
        ];
    }

    private static function calculateTypeBelgium($rawPhoneNumber): array
    {
        $localPrefix = BelgianPrefixes::isMobileOperator($rawPhoneNumber)['localPrefix'];

        if ($localPrefix) {
            return [
                'type' => PhoneNumberModel::TYPE_MOBILE,
                'localPrefix' => $localPrefix
            ];
        }

        $localPrefix = BelgianPrefixes::isFixedLineOperator($rawPhoneNumber)['localPrefix'];

        if ($localPrefix) {
            return [
                'type' => PhoneNumberModel::TYPE_FIXED,
                'localPrefix' => $localPrefix
            ];
        }

        return [
            'type' => PhoneNumberModel::TYPE_UNKNOWN,
            'localPrefix' => ''
        ];
    }
}
