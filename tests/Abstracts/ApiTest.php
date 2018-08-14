<?php

namespace wlbrough\clearbit\Abstracts;

use wlbrough\clearbit\Abstracts\Api;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private function buildMock()
    {
        return $this->getMockForAbstractClass('\wlbrough\clearbit\Abstracts\Api');
    }

    public function validEndpoints()
    {
        return [
            [ 'https://test.com' ],
            [ 'http://www.test.net' ],
            [ 'https://www.example.org' ],
            [ 'http://example.co.au' ]
        ];
    }

    public function invalidEndpoints()
    {
        return [
            [ 'test' ],
            [ 'test.com' ],
            [ 12345 ],
            [ ['https://test.com'] ]
        ];
    }

    public function testEmptyEndpointThrows()
    {
        /** @var Api $mock */
        $this->expectException(\InvalidArgumentException::class);
        $mock = $this->buildMock();
        $mock->setWebhookEndpoint();
    }

    /**
     * @dataProvider invalidEndpoints
     */
    public function testEndpointInvalid($endpoint)
    {
        /** @var Api $mock */
        $this->expectException(\InvalidArgumentException::class);
        $mock = $this->buildMock();
        $mock->setWebhookEndpoint($endpoint);
    }

    /**
     * @dataProvider validEndpoints
     */
    public function testEndpointValid($endpoint)
    {
        /** @var Api $mock */
        $mock = $this->buildMock();
        $mock->setWebhookEndpoint($endpoint);
        $this->assertAttributeEquals($endpoint, 'endpointUrl', $mock);
    }

    public function testEnableStreaming()
    {
        /** @var Api $mock */
        $mock = $this->buildMock();
        $mock->enableStreaming();
        $this->assertAttributeEquals(true, 'useStreaming', $mock);
    }
}
