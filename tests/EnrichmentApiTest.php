<?php

namespace wlbrough\clearbit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * @runTestsInSeparateProcesses
 */
class EnrichmentApiTest extends \PHPUnit\Framework\TestCase
{
    private function getMockClient($status, $type = null)
    {
        if ($status === 200) {
            $data = file_get_contents(__DIR__ . '/Mocks/Enrichment/' . $type . '.json');
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

    public function testSuccessfulCombinedCall()
    {
        $client = $this->getMockClient(200, 'combined');
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $enrichment = Clearbit::createEnrichmentApi();
        $data = $enrichment->combined('test@test.com');

        $this->assertObjectHasAttribute('person', $data);
        $this->assertObjectHasAttribute('company', $data);
    }

    public function testFailedCombinedCall()
    {
        $this->expectException(\wlbrough\clearbit\Exceptions\ApiException::class);

        $client = $this->getMockClient(404);
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $enrichment = Clearbit::createEnrichmentApi();
        $enrichment->combined('test@test.com');
    }

    public function testSuccessfulPersonCall()
    {
        $client = $this->getMockClient(200, 'person');
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $enrichment = Clearbit::createEnrichmentApi();
        $data = $enrichment->person('test@test.com');

        $this->assertEquals('Alex MacCaw', $data->name->fullName);
    }

    public function testFailedPersonCall()
    {
        $this->expectException(\wlbrough\clearbit\Exceptions\ApiException::class);

        $client = $this->getMockClient(404);
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $enrichment = Clearbit::createEnrichmentApi();
        $enrichment->person('test@test.com');
    }

    public function testSuccessfulCompanyCall()
    {
        $client = $this->getMockClient(200, 'company');
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $enrichment = Clearbit::createEnrichmentApi();
        $data = $enrichment->company('test.com');

        $this->assertEquals('Uber', $data->name);
    }

    public function testFailedCompanyCall()
    {
        $this->expectException(\wlbrough\clearbit\Exceptions\ApiException::class);

        $client = $this->getMockClient(404);
        Clearbit::setKey('token');
        Clearbit::setClient($client);

        $enrichment = Clearbit::createEnrichmentApi();
        $enrichment->company('test.com');
    }
}
