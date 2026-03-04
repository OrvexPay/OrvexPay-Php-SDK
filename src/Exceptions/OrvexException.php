<?php

namespace OrvexPay\Sdk\Exceptions;

use Exception;

class OrvexException extends Exception
{
    protected ?array $apiResponse = null;

    public function __construct(string $message, int $code = 0, ?array $apiResponse = null)
    {
        parent::__construct($message, $code);
        $this->apiResponse = $apiResponse;
    }

    public function getApiResponse(): ?array
    {
        return $this->apiResponse;
    }
}
