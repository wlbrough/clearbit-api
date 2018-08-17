<?php

namespace wlbrough\clearbit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class NameToDomainApiTest extends TestCase
{
    private function getMockClient($status)
    {
        if ($status === 200) {
            $data = file_get_contents(__DIR__ . '/Mocks/NameToDomain/name_to_domain.json');
        } else {
            $data = null;
        }

        $mock = new MockHandler([
            new Response($status, [], $data)
        ]);
        $handler = HandlerStack::create($mock);
        return new Client([
            'handler' => $handler,
            'http_errors' => false
        ]);
    }

    public function testGetSuccess()
    {
        $client = $this->getMockClient(200);
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $nameToDomain = Clearbit::createNameToDomain();
        $company = $nameToDomain->get('Segment');
        $this->assertObjectHasAttribute('domain', $company);
    }

    public function testGetFailure()
    {
        $this->expectException(\wlbrough\clearbit\Exceptions\ApiException::class);

        $client = $this->getMockClient(404);
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $nameToDomain = Clearbit::createNameToDomain();
        $nameToDomain->get('Invalid Name');
    }
}
