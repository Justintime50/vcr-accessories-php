<?php

namespace VCRAccessories\Tests\VCRAccessories;

use PHPUnit\Framework\TestCase;
use VCRAccessories\CassetteSetup;

class CassetteExpirationTest extends TestCase
{
    /**
     * Tests that we throw a warning when a cassette is expired.
     *
     * TODO: You will need to verify this manually for now, fix this.
     *
     * @return void
     */
    public function testCassetteExpirationWarning()
    {
        CassetteSetup::setupVcrTests();

        CassetteSetup::setupCassette('cassetteExpirationWarning.yaml', 0, false);

        $client = new \GuzzleHttp\Client();
        $client->request('GET', 'https://httpbingo.org/get', ['headers' => ['Accept' => 'application/json']]);

        // Sleep so that timestamps are off by a second
        sleep(1);

        $this->assertTrue(true);

        CassetteSetup::teardownVcrTests();
    }
}
