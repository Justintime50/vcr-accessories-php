<?php

namespace VCRAccessories\Tests\VCRAccessories;

use PHPUnit\Framework\TestCase;
use VCRAccessories\CassetteExpirationException;

class CassetteExpirationExceptionTest extends TestCase
{
    /**
     * Tests that we construct a CassetteExpirationException correctly.
     *
     * @return void
     */
    public function testAllAccessories()
    {
        try {
            throw new CassetteExpirationException('Cassette has expired!');
            $this->assertFalse(true); // @phpstan-ignore-line
        } catch (CassetteExpirationException $error) {
            $this->assertEquals('Cassette has expired!', $error->getMessage());
        }
    }
}
