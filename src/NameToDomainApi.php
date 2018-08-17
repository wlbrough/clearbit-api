<?php

namespace wlbrough\clearbit;

use wlbrough\clearbit\Abstracts\Api;

class NameToDomainApi extends Api
{
    private static $apiUrlTemplate = 'https://pk:@company.clearbit.com/v1/domains/find?name=%s';

    public function __construct($key, $client = null)
    {
        self::$apiUrlTemplate = preg_replace('(pk)', $key, self::$apiUrlTemplate);
        $this->httpClient = $client;
    }

    public function get($companyName)
    {
        $apiUrl = sprintf(self::$apiUrlTemplate, urlencode($companyName));
        return $this->call($apiUrl, $this->httpClient);
    }
}
