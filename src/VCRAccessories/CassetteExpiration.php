<?php

namespace VCRAccessories;

class CassetteExpiration
{
    /**
     * Checks for an expired cassette and warns if it is too old and must be re-recorded.
     *
     * @param string $cassettePath
     * @return void
     */
    public static function checkExpiredCassette(string $cassettePath): void
    {
        // TODO: Make these configurable
        $fullCassettePath = "test/cassettes/$cassettePath";
        $secondsInDay = 86400;
        $expirationDays = 180;
        $expirationSeconds = $secondsInDay * $expirationDays;

        if (file_exists($fullCassettePath)) {
            $cassetteTimestamp = filemtime($fullCassettePath);
            $expirationTimestamp = $cassetteTimestamp + $expirationSeconds;
            $currentTimestamp = time();

            if ($currentTimestamp > $expirationTimestamp) {
                // TODO: allow for errors on expiration in addition to default warnings
                error_log("$fullCassettePath is older than $expirationDays days and has expired. Please re-record the cassette.");
            }
        }
    }
}
