<?php

namespace wlbrough\clearbit\Abstracts;

use GuzzleHttp\Client;
use wlbrough\clearbit\Exceptions\ApiException;

abstract class Api
{
    protected $endpointUrl = null;
    protected $useStreaming = false;
    protected $httpClient = null;

    public function setWebhookEndpoint($endpointUrl = null)
    {
        self::validateUrl($endpointUrl);
        $this->endpointUrl = $endpointUrl;
    }

    public function enableStreaming()
    {
        $this->useStreaming = true;
    }

    private static function validateUrl($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('Webhook endpoint is not a string');
        }

        $isValid = preg_match('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $url);

        if (!$isValid) {
            throw new \InvalidArgumentException('Webhook endpoint is not a URL');
        }

        return true;
    }

    protected static function call($url, $client)
    {
        if (!$client) {
            $client = new Client(['http_errors' => false]);
        }

        $response = $client->get($url);
        $status = $response->getStatusCode();

        if ($status === 200) {
            $returnData = json_decode($response->getBody());
        } else {
            throw new ApiException($status);
        }

        return $returnData;
    }

    protected static function post($url, $body, $successCode = 200, $client = null)
    {
        if (!$client) {
            $client = new Client(['http_errors' => false]);
        }

        $response = $client->post($url, [
            'form_params' => $body
        ]);
        $status = $response->getStatusCode();

        return $status === $successCode;
    }
}
