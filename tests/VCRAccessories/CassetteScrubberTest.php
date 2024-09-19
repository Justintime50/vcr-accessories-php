<?php

namespace VCRAccessories\Tests\VCRAccessories;

use PHPUnit\Framework\TestCase;
use VCRAccessories\CassetteScrubber;

class CassetteScrubberTest extends TestCase
{
    /**
     * Tests that we can determine if a PHP "item" is a list or not.
     *
     * @return void
     */
    public function testScrubCassette()
    {

        $scrubbers = [
            ['phone', '<REDACTED>'],
            ['secret', '<TOP SECRET>'],
        ];

        // Test a traditional JSON response
        $mockResponse = '{"name": "John", "age": 64, "phone": 1234567890, "children": [{"name": "Sussy", "age": 22, "phone": 9876543210, "secret": "show nobody"}]}'; // phpcs:ignore
        $data = json_decode($mockResponse, true);

        $scrubbedData = CassetteScrubber::scrubCassette($scrubbers, $data);

        $this->assertEquals(
            '{"name":"John","age":64,"phone":"<REDACTED>","children":[{"name":"Sussy","age":22,"phone":"<REDACTED>","secret":"<TOP SECRET>"}]}', // phpcs:ignore
            json_encode($scrubbedData)
        );

        // Test a nested JSON response in a list
        $mockResponse = '[{"name": "John", "age": 64, "phone": 1234567890, "children": [{"name": "Sussy", "age": 22, "phone": 9876543210, "secret": "show nobody"}]}]'; // phpcs:ignore
        $data = json_decode($mockResponse, true);

        $scrubbedData = CassetteScrubber::scrubCassette($scrubbers, $data);

        $this->assertEquals(
            '[{"name":"John","age":64,"phone":"<REDACTED>","children":[{"name":"Sussy","age":22,"phone":"<REDACTED>","secret":"<TOP SECRET>"}]}]', // phpcs:ignore
            json_encode($scrubbedData)
        );
    }
}
