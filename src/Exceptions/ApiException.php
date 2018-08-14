<?php

namespace wlbrough\clearbit\Exceptions;

use Throwable;

class ApiException extends \Exception
{
    public function __construct($code, Throwable $previous = null)
    {
        if ($code === 400) {
            $message = "Bad Request";
        } elseif ($code === 401) {
            $message = "Your API key is invalid";
        } elseif ($code === 402) {
            $message = "Over plan quota on this endpoint";
        } elseif ($code === 404) {
            $message = "The resource does not exist";
        } elseif ($code === 422) {
            $message = "A validation error occurred";
        } elseif ($code >= 500 && code < 600) {
            $message = "An error occurred with our API";
        } else {
            $message = "Unknown error";
        }

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
