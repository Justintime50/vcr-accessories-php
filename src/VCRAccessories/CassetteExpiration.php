<?php

namespace VCRAccessories;

const SECONDS_IN_DAY = 86400;

class CassetteExpiration
{
    /**
     * Checks for an expired cassette and warns if it is too old and must be re-recorded.
     *
     * @param int $expirationDays
     * @param string $fullCassettePath
     * @param bool $error
     * @return void
     */
    public static function checkExpiredCassette(int $expirationDays, string $fullCassettePath, bool $error = false): void
    {
        $expirationSeconds = SECONDS_IN_DAY * $expirationDays;

        if (file_exists($fullCassettePath)) {
            $cassetteTimestamp = filemtime($fullCassettePath);
            $expirationTimestamp = $cassetteTimestamp + $expirationSeconds;
            $currentTimestamp = time();

            if ($currentTimestamp > $expirationTimestamp) {
                $message = "$fullCassettePath is older than $expirationDays days and has expired. Please re-record the cassette.";

                if ($error === true) {
                    throw new CassetteExpirationException($message);
                } else {
                    error_log($message);
                }
            }
        }
    }
}
