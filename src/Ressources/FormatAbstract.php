<?php

declare(strict_types=1);

namespace Helip\PhoneNumber\Ressources;

abstract class FormatAbstract
{
    abstract public static function format(string $phoneNumber, string $type, string $prefix): string;
    abstract protected static function formatLocal(string $phoneNumber, string $prefix): string;
    abstract protected static function formatMobile(string $phoneNumber): string;
}
