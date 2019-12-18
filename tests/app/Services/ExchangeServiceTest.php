<?php

namespace Tests\App\Services;

use App\Services\ExchangeService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use TestCase;
use Mockery;

class ExchangeServiceTest extends TestCase
{
    private $sut;

    private $client;

    public function setUp():void
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->sut = new ExchangeService($this->client);
    }

    public function testGetTheLatestExchangeRatesForGBP()
    {
        $response = Mockery::mock(Response::class);

        $stream = Mockery::mock(Stream::class);

        $stream
            ->shouldReceive('getContents')
            ->once()
            ->andReturn("{\"rates\":{\"2019-12-17\":{\"EUR\":1.1799688488},\"2019-12-16\":{\"EUR\":1.1988251514},\"2019-12-11\":{\"EUR\":1.1870140661},\"2019-12-13\":{\"EUR\":1.1974900608},\"2019-12-12\":{\"EUR\":1.1825922422}},\"start_at\":\"2019-12-11\",\"base\":\"GBP\",\"end_at\":\"2019-12-18\"}");

        $response
            ->shouldReceive('getBody')
            ->once()
            ->andReturn($stream);

        $this->client
            ->shouldReceive('get')
            ->once()
            ->with("https://api.exchangeratesapi.io/history?start_at=2019-12-11&end_at=2019-12-18&base=GBP&symbols=EUR")
            ->andReturn($response);

        $this->assertEquals(
            "{\"rates\":{\"2019-12-17\":{\"EUR\":1.1799688488},\"2019-12-16\":{\"EUR\":1.1988251514},\"2019-12-11\":{\"EUR\":1.1870140661},\"2019-12-13\":{\"EUR\":1.1974900608},\"2019-12-12\":{\"EUR\":1.1825922422}},\"start_at\":\"2019-12-11\",\"base\":\"GBP\",\"end_at\":\"2019-12-18\"}",
            $this->sut->getLatestExchangeRate('GBP', '2019-12-11', '2019-12-18')
        );
    }

    public function testGetTheLatestExchangeRatesForUSD()
    {
        $response = Mockery::mock(Response::class);

        $stream = Mockery::mock(Stream::class);

        $stream
            ->shouldReceive('getContents')
            ->once()
            ->andReturn("{\"rates\":{\"2019-12-17\":{\"EUR\":0.8958967927},\"2019-12-16\":{\"EUR\":0.8971828459},\"2019-12-11\":{\"EUR\":0.9029345372},\"2019-12-13\":{\"EUR\":0.8949346698},\"2019-12-12\":{\"EUR\":0.8979078747}},\"start_at\":\"2019-12-11\",\"base\":\"USD\",\"end_at\":\"2019-12-18\"}");

        $response
            ->shouldReceive('getBody')
            ->once()
            ->andReturn($stream);

        $this->client
            ->shouldReceive('get')
            ->once()
            ->with("https://api.exchangeratesapi.io/history?start_at=2019-12-11&end_at=2019-12-18&base=USD&symbols=EUR")
            ->andReturn($response);

        $this->assertEquals(
            "{\"rates\":{\"2019-12-17\":{\"EUR\":0.8958967927},\"2019-12-16\":{\"EUR\":0.8971828459},\"2019-12-11\":{\"EUR\":0.9029345372},\"2019-12-13\":{\"EUR\":0.8949346698},\"2019-12-12\":{\"EUR\":0.8979078747}},\"start_at\":\"2019-12-11\",\"base\":\"USD\",\"end_at\":\"2019-12-18\"}",
            $this->sut->getLatestExchangeRate('USD', '2019-12-11', '2019-12-18')
        );
    }
}
