# Helip PhoneNumber Library

Helip PhoneNumber is a simple PHP library for validating and formatting phone numbers. This library supports identifying phone number types (mobile, fixed) and converting phone numbers to their international format.

## Limitations
Currently, the library only formats and validates Belgian phone numbers.
International countries currently recognized but not formatted: FR, DE, NL, LU, CH, AT, IE, GB, LI

## Installation

To install the library, use Composer:

```bash
composer require helip/phonenumber
```

## Usage

### Basic Example

```php
use Helip\PhoneNumber\PhoneNumber;
use Helip\PhoneNumber\Exceptions\InvalidPhoneNumberException;

try {
    $phoneNumber = new PhoneNumber('+32471234567');
    echo $phoneNumber->getInternationalFormat(); // Output: +32 471 234 567
    echo $phoneNumber->getCountryCode(); // Output: BE
    echo $phoneNumber->getType(); // Output: PhoneNumberModel::TYPE_MOBILE
} catch (InvalidPhoneNumberException $e) {
    echo 'Invalid phone number.';
}
```

### Features

- **Phone Number Validation:** Checks if a phone number is valid and matches the expected format.
- **Country Code Detection:** Identifies the country based on the phone number. Currently supports Belgian phone numbers.
- **Phone Number Type Detection:** Differentiates between mobile and fixed phone numbers.
- **International Format:** Converts phone numbers to a standardized international format.

## Running Tests

This library includes PHPUnit tests to validate its functionality. You can run the tests by executing:

```bash
vendor/bin/phpunit
```

## Contributing

Feel free to submit issues and pull requests. Make sure to follow the coding standards using PHPStan and PHP CS Fixer.

## License

This library is licensed under the LGPL-3.0-or-later license.