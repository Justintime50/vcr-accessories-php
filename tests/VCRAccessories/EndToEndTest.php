<?php

namespace VCRAccessories\Tests;

use PHPUnit\Framework\TestCase;
use VCRAccessories\CassetteSetup;

class EndToEndTest extends TestCase
{
    /**
     * Tests that we setup and use a cassette with the bare minumum config.
     *
     * @return void
     */
    public function testSetupCassetteBasicUsage()
    {
        CassetteSetup::setupVcrTests();

        CassetteSetup::setupCassette('setupCassetteBasicUsage.yaml');

        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://example.com');
        $responseContents = $response->getBody();

        $this->assertNotNull($responseContents);

        CassetteSetup::teardownVcrTests();
    }
}
