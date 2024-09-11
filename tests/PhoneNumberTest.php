<?php

namespace Tests\Unit;

use Helip\PhoneNumber\Exceptions\InvalidPhoneNumberException;
use Helip\PhoneNumber\Models\PhoneNumberModel;
use Helip\PhoneNumber\PhoneNumber;
use Helip\PhoneNumber\Ressources\InternationalPrefixes;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    public function testPhoneNumberCountryCode()
    {
        $dataProvider = $this->phoneNumberDataProvider();

        foreach ($dataProvider as $data) {
            [$rawPhoneNumber, $expectedInternationalFormat, $expectedCountryCode, $expectedType, $expectedException] = $data;

            if ($expectedException) {
                $this->expectException($expectedException);
                $phoneNumber = new PhoneNumber($rawPhoneNumber); // This line will throw the exception
            } else {
                $phoneNumber = new PhoneNumber($rawPhoneNumber);
                $this->assertEquals($expectedCountryCode, $phoneNumber->getCountryCode(), "Failed asserting country code for $rawPhoneNumber");
            }
        }
    }

    public function testPhoneNumberType()
    {
        $dataProvider = $this->phoneNumberDataProvider();

        foreach ($dataProvider as $data) {
            [$rawPhoneNumber, $expectedInternationalFormat, $expectedCountryCode, $expectedType, $expectedException] = $data;

            if ($expectedException) {
                $this->expectException($expectedException);
                $phoneNumber = new PhoneNumber($rawPhoneNumber); // This line will throw the exception
            } else {
                $phoneNumber = new PhoneNumber($rawPhoneNumber);
                $this->assertEquals($expectedType, $phoneNumber->getType(), "Failed asserting type for $rawPhoneNumber");
            }
        }
    }

    public function testPhoneNumberInternationalFormat()
    {
        $dataProvider = $this->phoneNumberDataProvider();

        foreach ($dataProvider as $data) {
            [$rawPhoneNumber, $expectedInternationalFormat, $expectedCountryCode, $expectedType, $expectedException] = $data;

            if ($expectedException) {
                $this->expectException($expectedException);
                $phoneNumber = new PhoneNumber($rawPhoneNumber); // This line will throw the exception
            } else {
                $phoneNumber = new PhoneNumber($rawPhoneNumber);

                // Assert the international format is correct
                $this->assertEquals(
                    $expectedInternationalFormat,
                    $phoneNumber->getInternationalFormat(),
                    "Failed asserting international format for $rawPhoneNumber"
                );
            }
        }
    }


    /**
     * Fournisseur de données personnalisé pour testPhoneNumber
     *
     * @return array
     */
    public function phoneNumberDataProvider(): array
    {
        return [
            // Format: [rawPhoneNumber, expectedInternationalFormat, expectedCountryCode, expectedType, expectedException]
            ['+32471234567', '+32 471 234 567', 'BE', PhoneNumberModel::TYPE_MOBILE, null],
            ['+324 71  2345 67', '+32 471 234 567', 'BE', PhoneNumberModel::TYPE_MOBILE, null],
            ['+3210614236', '+32 10 61 42 36', 'BE', PhoneNumberModel::TYPE_FIXED, null],
            ['+33612345678', null, 'FR', PhoneNumberModel::TYPE_UNKNOWN, null],
            ['+14151234567', null, InternationalPrefixes::ERROR_UNKNOWN_COUNTRY, PhoneNumberModel::TYPE_UNKNOWN, null],
            
            ['0032471234567', '+32 471 234 567', 'BE', PhoneNumberModel::TYPE_MOBILE, null],
            ['003210614236', '+32 10 61 42 36', 'BE', PhoneNumberModel::TYPE_FIXED, null],
            ['0033612345678', null, 'FR', PhoneNumberModel::TYPE_UNKNOWN, null],
            ['0014151234567', null, InternationalPrefixes::ERROR_UNKNOWN_COUNTRY, PhoneNumberModel::TYPE_UNKNOWN, null],

            ['+324 71  2345 6', null, null, PhoneNumberModel::TYPE_UNKNOWN, InvalidPhoneNumberException::class], # missing number
            ['fefezf', null, null, PhoneNumberModel::TYPE_UNKNOWN, InvalidPhoneNumberException::class], # invalid number
            [null, null, null, PhoneNumberModel::TYPE_UNKNOWN, InvalidPhoneNumberException::class], # null
            ['', null, null, PhoneNumberModel::TYPE_UNKNOWN, InvalidPhoneNumberException::class], # empty string
            [32471234567, null, null, PhoneNumberModel::TYPE_UNKNOWN, InvalidPhoneNumberException::class], # integer
        ];
    }
}
