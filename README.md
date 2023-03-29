# VCR Accessories

[![Build Status](https://github.com/Justintime50/vcr-accessories-php/workflows/build/badge.svg)](https://github.com/Justintime50/vcr-accessories-php/actions)
[![Coverage Status](https://coveralls.io/repos/github/Justintime50/vcr-accessories-php/badge.svg?branch=main)](https://coveralls.io/github/Justintime50/vcr-accessories-php?branch=main)
[![Licence](https://img.shields.io/github/license/justintime50/vcr-accessories-php)](LICENSE)

Various tools and accessories for your [PHP VCR](https://github.com/php-vcr/php-vcr)

When working with VCR solutions, I'm often finding I need a few extra "accessories" to get them working the way I want. This package includes the following:

- Cassette scrubbing (eg: sensitive data)
- Expire and warn or error on stale cassettes
- Setup a cassette directory
- Setup and teardown VCR tests

## Usage

### bootstrap.php

```php
use allejo\VCR\VCRCleaner;
use VCR\VCR;
use VCRAccessories\CassetteScrubber;
use VCRAccessories\CassetteSetup;

const CASSETTE_DIR = 'tests/cassettes';
CassetteSetup::setupCassetteDirectory(CASSETTE_DIR);

VCR::configure()->setCassettePath(CASSETTE_DIR)
    ->setStorage('yaml')
    ->setMode('once')
    ->setWhiteList(['vendor/guzzle']);

const REDACTED_STRING = '<REDACTED>';

// SCRUBBERS must be a multidimensional array where the first index of each nested array is the key
// you want to scrub and the second index is what you want it to be replaced with before persisting to disk
const SCRUBBERS = [
    ['origin', REDACTED_STRING],
];

VCRCleaner::enable([
    'response' => [
        'bodyScrubbers' => [
            function ($responseBody) {
                $responseBodyJson = json_decode($responseBody, true);
                $responseBodyEncoded = CassetteScrubber::scrubCassette(SCRUBBERS, $responseBodyJson);

                // Re-encode the data so we can properly store it in the cassette
                return json_encode($responseBodyEncoded);
            }
        ],
    ],
]);
```

### Test File

```php
use VCRAccessories\CassetteSetup;

public static function setUpBeforeClass(): void
{
    CassetteSetup::setupVcrTests();
}

public static function tearDownAfterClass(): void
{
    CassetteSetup::teardownVcrTests();
}

public function myTest()
{
    // 1. Pass the name of the cassette (required)
    // 2. Pass an optional number of days to expire this cassette after
    // 3. Pass true if you want to error on expired cassettes instead of error
    CassetteSetup::setupCassette('nameOfCassette.yaml', 180, true);

    // Your test here
}
```

## Development

```bash
# Install dependencies
composer install

# Lint
composer lint
composer fix

# Test
composer test
composer coverage
```
