<?php

namespace wlbrough\clearbit;

use wlbrough\clearbit\Abstracts\Api;

class EnrichmentApi extends Api
{
    private static $apiUrlTemplate = 'https://pk:@%s%s.clearbit.com/v2/%s/find?%s=%s';

    public function __construct($key, $client = null)
    {
        self::$apiUrlTemplate = preg_replace('(pk)', $key, self::$apiUrlTemplate);
        $this->httpClient = $client;
    }

    public function combined($email)
    {
        $apiUrl = $this->composeUrl('person', 'combined', 'email', $email);
        return $this->call($apiUrl, $this->httpClient);
    }

    public function person($email, $subscribe = false)
    {
        $apiUrl = $this->composeUrl('person', 'people', 'email', $email);

        if ($subscribe) {
            $apiUrl .= '&subscribe=true';
        }

        return $this->call($apiUrl, $this->httpClient);
    }

    public function flagPerson($personId, $corrected = null)
    {
        $apiUrl = "https://person.clearbit.com/v1/people/$personId/flag";
        return $this->post($apiUrl, $corrected, 200, $this->httpClient);
    }

    public function company($domain)
    {
        $apiUrl = $this->composeUrl('company', 'companies', 'domain', $domain);
        return $this->call($apiUrl, $this->httpClient);
    }

    public function flagCompany($domain, $corrected = null)
    {
        $apiUrl = "https://company.clearbit.com/v2/companies/flag?domain=$domain";
        return $this->post($apiUrl, $corrected, 200, $this->httpClient);
    }

    private function composeUrl($subdomain, $path, $query, $parameter)
    {
        $streaming = $this->useStreaming ? '-stream' : '';
        return sprintf(self::$apiUrlTemplate, $subdomain, $streaming, $path, $query, $parameter);
    }
}
