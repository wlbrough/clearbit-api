<?php

namespace wlbrough\clearbit;

use wlbrough\clearbit\Clearbit;
use wlbrough\clearbit\Exceptions\ClearbitException;

/**
 * @runTestsInSeparateProcesses
 */
class ClearbitTest extends \PHPUnit\Framework\TestCase
{
    public function invalidKeys()
    {
        return [
            'empty' => [ '' ],
            'a' => [ 'a' ],
            'ab' => [ 'ab' ],
            'digit' => [ 1 ],
            'bool' => [ true ],
            'array' => [ [ 'token' ] ]
        ];
    }

    public function validKeys()
    {
        return [
            'token' => [ 'token' ],
            'short-hash' => [ '123456789' ],
            'full-hash' => [ 'akrwejhtn983z420qrzc8397r4' ]
        ];
    }

    /**
     * @dataProvider invalidKeys
     */
    public function testSetTokenRaisesExceptionOnInvalidKey($key)
    {
        $this->expectException(\InvalidArgumentException::class);
        Clearbit::setKey($key);
    }

    /**
     * @dataProvider validKeys
     */
    public function testSetTokenSucceedsOnValidToken($key)
    {
        Clearbit::setKey($key);
        $clearbit = new Clearbit();
        $this->assertInstanceOf('wlbrough\clearbit\Clearbit', $clearbit);
    }

    public function testInstantiationWithNoGlobalKeyAndNoArgumentRaisesException()
    {
        $this->expectException(ClearbitException::class);
        new Clearbit();
    }

    public function testInstantiationWithGlobalKeyAndNoArgumentsSucceeds()
    {
        Clearbit::setKey('token');
        $clearbit = new Clearbit();
        $this->assertInstanceOf('wlbrough\clearbit\Clearbit', $clearbit);
    }

    public function testInstantiationWithGlobalKeyAndArgumentsSucceeds()
    {
        Clearbit::setKey('token');
        $clearbit = new Clearbit('123456789');
        $this->assertInstanceOf('wlbrough\clearbit\Clearbit', $clearbit);
    }

    public function testGetKeyReturnsInstanceKeyWhenSet()
    {
        Clearbit::setKey('token');
        $clearbit = new Clearbit('123456789');
        $this->assertEquals($clearbit->getKey(), '123456789');
    }

    public function testGetKeyReturnsStaticKeyWhenNoInstanceKeySet()
    {
        Clearbit::setKey('token');
        $clearbit = new Clearbit();
        $this->assertEquals($clearbit->getKey(), 'token');
    }

    public function testStaticEnrichmentApiMethodReturnsInstanceOfEnrichmentApi()
    {
        Clearbit::setKey('token');
        $enrichment = Clearbit::createEnrichmentApi();
        $this->assertInstanceOf('wlbrough\clearbit\EnrichmentApi', $enrichment);
    }

    public function testInstanceEnrichmentApiMethodReturnsInstanceOfEnrichmentApi()
    {
        $clearbit = new Clearbit('123456789');
        $enrichment = $clearbit->enrichmentApi();
        $this->assertInstanceOf('wlbrough\clearbit\EnrichmentApi', $enrichment);
    }
}
