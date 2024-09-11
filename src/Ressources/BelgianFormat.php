<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Ressources;

use Helip\PhoneNumber\Exceptions\InvalidPhoneNumberException;
use Helip\PhoneNumber\Models\PhoneNumberModel;

final class BelgianFormat extends FormatAbstract
{
    /**
     * Format a phone number.
     *
     * @param string $phoneNumber The phone number to format.
     * @param string $type The phone number type.
     * @param string $prefix The international prefix of the phone number.
     * @return string The formatted phone number.
     *
     * @throws InvalidPhoneNumberException If the phone number is invalid.
     */
    public static function format(string $phoneNumber, string $type, string $prefix): string
    {
        if ($type === PhoneNumberModel::TYPE_MOBILE) {
            return self::formatMobile($phoneNumber);
        } elseif ($type === PhoneNumberModel::TYPE_FIXED) {
            return self::formatLocal($phoneNumber, $prefix);
        }

        throw new InvalidPhoneNumberException();
    }

    protected static function formatLocal(string $phoneNumber, string $prefix): string
    {
        $cleaned = preg_replace('/\D/', '', $phoneNumber);
        $length = strlen($cleaned);
        $prefixLength = strlen($prefix);

        if ($prefixLength === 2) {
            // Format 00 000 00 00
            return preg_replace('/(\d{2})(\d{3})(\d{2})(\d{2})/', '$1 $2 $3 $4', $cleaned);
        } elseif ($prefixLength === 3) {
            // Format 000 00 00 00
            return preg_replace('/(\d{3})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4', $cleaned);
        }

        throw new InvalidPhoneNumberException();
    }

    protected static function formatMobile(string $phoneNumber): string
    {
        $cleaned = preg_replace('/\D/', '', $phoneNumber);
        $length = strlen($cleaned);

        if ($length === 10) {
            // Format 0000 000 000
            return preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1 $2 $3', $cleaned);
        }

        throw new InvalidPhoneNumberException();
    }
}
