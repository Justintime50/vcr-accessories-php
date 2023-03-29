<?php

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
define('SCRUBBERS', [
    ['origin', REDACTED_STRING],
]);

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
