<?php

namespace VCRAccessories;

class CassetteExpirationException extends \Exception
{
    /**
     * CassetteExpirationException constructor.
     *
     * @param string $message
     */
    public function __construct($message = null)
    {
        parent::__construct($message);
    }
}
