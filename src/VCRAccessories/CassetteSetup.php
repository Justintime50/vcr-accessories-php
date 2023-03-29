<?php

namespace VCRAccessories;

use VCR\VCR;
use VCRAccessories\CassetteExpiration;

class CassetteSetup
{
    /**
     * Runs all the logic required to setup a VCR test.
     *
     * @return void
     */
    public static function setupVcrTests(): void
    {
        VCR::turnOn();
    }

    /**
     * Runs all the logic required to teardown a VCR test.
     *
     * @return void
     */
    public static function teardownVcrTests(): void
    {
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * Inserts a cassette for use in tests and checks if it's expired.
     *
     * @param string $cassetteName
     * @param int|null $expirationDays
     * @param bool $expirationError
     * @return void
     */
    public static function setupCassette(string $cassetteName, int|null $expirationDays = null, $expirationError = false): void
    {
        if (isset($expirationDays)) {
            CassetteExpiration::checkExpiredCassette($cassetteName, $expirationDays, $expirationError);
        }

        VCR::insertCassette($cassetteName);
    }

    /**
     * Sets up the cassette directory if it does not yet exist.
     *
     * @param string $cassetteDir
     * @return void
     */
    public static function setupCassetteDirectory(string $cassetteDir): void
    {
        if (!file_exists($cassetteDir)) {
            mkdir($cassetteDir, 0755, true);
        }
    }
}
