<?php

namespace VCRAccessories;

class CassetteExpirationException extends \Exception
{
    /**
     * CassetteExpirationException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
