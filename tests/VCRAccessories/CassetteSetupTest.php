<?php

namespace VCRAccessories\Tests\VCRAccessories;

use PHPUnit\Framework\TestCase;
use VCRAccessories\CassetteSetup;

class CassetteSetupTest extends TestCase
{
    public function testSetupCassetteDirectory(): void
    {
        $mockDir = 'tests/mock';
        CassetteSetup::setupCassetteDirectory($mockDir);

        // TODO: Mock the creation of the directory
        $this->assertTrue(is_dir($mockDir));
        rmdir($mockDir);
    }
}
