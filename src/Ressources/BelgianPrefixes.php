<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Ressources;

use Helip\PhoneNumber\Exceptions\InvalidPhoneNumberException;

class BelgianPrefixes
{
    private static array $fixedLinePrefixes = [
        '010' => 'Wavre',
        '011' => 'Hasselt',
        '012' => 'Tongeren',
        '013' => 'Diest',
        '014' => 'Herentals',
        '015' => 'Mechelen',
        '016' => 'Leuven',
        '019' => 'Waremme',
        '02'  => 'Brussels, Enghien',
        '03'  => 'Antwerp',
        '04'  => 'Liège, Fourons',
        '050' => 'Bruges',
        '051' => 'Roeselare',
        '052' => 'Dendermonde',
        '053' => 'Aalst',
        '054' => 'Ninove',
        '055' => 'Oudenaarde',
        '056' => 'Kortrijk, Comines-Warneton, Mouscron',
        '057' => 'Ypres',
        '058' => 'Veurne',
        '059' => 'Ostend',
        '060' => 'Chimay',
        '061' => 'Libramont-Chevigny, Bastogne',
        '063' => 'Arlon',
        '064' => 'La Louvière',
        '065' => 'Mons',
        '067' => 'Nivelles',
        '068' => 'Ath',
        '069' => 'Tournai',
        '071' => 'Charleroi',
        '080' => 'Stavelot, Malmedy, Waimes',
        '081' => 'Namur',
        '082' => 'Dinant',
        '083' => 'Ciney',
        '084' => 'Marche-en-Famenne',
        '085' => 'Huy, Andenne',
        '086' => 'Durbuy',
        '087' => 'Verviers',
        '089' => 'Genk',
        '09'  => 'Ghent'
    ];

    private static array $mobileOperatorsPrefixes = [
        '0455' => 'Voo',
        '0456' => 'Mobile Vikings',
        '0460' => 'Proximus',
        '0461' => 'GSM-R (Infrabel)',
        '0465' => 'Lycamobile',
        '0466' => 'Lycamobile',
        '0467' => 'Join Experience (no longer operating in Belgium since December 2018)',
        '0468' => 'Telenet',
        '0470' => 'Proximus',
        '0471' => 'Proximus',
        '0472' => 'Proximus',
        '0473' => 'Proximus',
        '0474' => 'Proximus',
        '0475' => 'Proximus',
        '0476' => 'Proximus',
        '0477' => 'Proximus',
        '0478' => 'Proximus',
        '0479' => 'Proximus',
        '0480' => 'Telenet',
        '0483' => 'BASE',
        '0484' => 'BASE',
        '0485' => 'BASE',
        '0486' => 'BASE',
        '0487' => 'BASE',
        '0488' => 'BASE',
        '0489' => 'BASE',
        '0490' => 'Orange',
        '0491' => 'Orange',
        '0492' => 'Orange',
        '0493' => 'Orange',
        '0494' => 'Orange',
        '0495' => 'Orange',
        '0496' => 'Orange',
        '0497' => 'Orange',
        '0498' => 'Orange',
        '0499' => 'Orange'
    ];

    public static function isMobileOperator(string $number): array
    {
        if (!preg_match('/^[0-9]+$/', $number)) {
            throw new InvalidPhoneNumberException('Passed number is not only digits: ' . $number);
        }

        // get 4 first digits (mobile operator)
        $mobileOperator = substr($number, 0, 4);

        // check if the mobile operator is in the list of mobile operators (key)
        if (array_key_exists($mobileOperator, self::$mobileOperatorsPrefixes)) {
            return [
                'localPrefix' => $mobileOperator
            ];
        }

        return [
            'localPrefix' => null
        ];
    }

    public static function isFixedLineOperator(string $number): array
    {
        if (!preg_match('/^[0-9]+$/', $number)) {
            throw new \Exception('Passed number is not only digits' . $number);
        }

        // get 3 first digits (fixed line operator)
        $fixedLineOperator = substr($number, 0, 3);

        // check if the fixed line operator is in the list of fixed line operators
        if (array_key_exists($fixedLineOperator, self::$fixedLinePrefixes)) {
            return [
                'localPrefix' => $fixedLineOperator
            ];
        }

        // check 2 first digits (fixed line operator)
        $fixedLineOperator = substr($number, 0, 2);

        // check if the fixed line operator is in the list of fixed line operators
        if (array_key_exists($fixedLineOperator, self::$fixedLinePrefixes)) {
            return [
                'localPrefix' => $fixedLineOperator
            ];
        }

        return [
            'localPrefix' => null
        ];
    }
}
