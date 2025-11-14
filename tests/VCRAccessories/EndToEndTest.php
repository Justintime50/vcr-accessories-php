<?php

namespace VCRAccessories\Tests\VCRAccessories;

use PHPUnit\Framework\TestCase;
use VCRAccessories\CassetteSetup;

class EndToEndTest extends TestCase
{
    /**
     * Tests that we setup, use, scrub, and expire a cassette with the bare minumum config.
     *
     * @return void
     */
    public function testAllAccessories()
    {
        CassetteSetup::setupVcrTests();

        CassetteSetup::setupCassette('allAccessories.yaml', 180, true);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://httpbingo.org/get', ['headers' => [
            'Accept' => 'application/json'
        ]]);
        $responseContents = json_decode($response->getBody(), true);

        $this->assertNotNull($responseContents);

        CassetteSetup::teardownVcrTests();
    }
}
