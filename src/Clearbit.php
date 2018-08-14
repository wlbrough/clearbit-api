<?php

namespace wlbrough\clearbit;

use wlbrough\clearbit\Exceptions\ClearbitException;

class Clearbit
{
    private static $clearbitKey = null;
    private static $httpClient = null;

    private $instanceKey;

    /**
     * Clearbit constructor.
     *
     * @param $key Clearbit API Key
     * @throws ClearbitException
     */
    public function __construct($key = null)
    {
        if ($key === null) {
            if (self::$clearbitKey === null) {
                $msg = 'No token provided and none globally set. ';
                $msg .= 'Use Clearbit::setKey, or instantiate the Clearbit class with a $clearbit_key parameter.';

                throw new ClearbitException($msg);
            }
        } else {
            self::validateKey($key);
            $this->instanceKey = $key;
        }
    }

    public static function setKey($key)
    {
        self::validateKey($key);
        self::$clearbitKey = $key;
    }

    public static function setClient($client)
    {
        self::$httpClient = $client;
    }

    public static function createEnrichmentApi()
    {
        return new EnrichmentApi(self::$clearbitKey, self::$httpClient);
    }

    public function enrichmentApi()
    {
        return new EnrichmentApi($this->getKey(), self::$httpClient);
    }

    private static function validateKey($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Key is not a string');
        }

        if (strlen($key) < 4) {
            throw new \InvalidArgumentException('Token too short');
        }

        return true;
    }

    public function getKey()
    {
        return $this->instanceKey ?: self::$clearbitKey;
    }
}
