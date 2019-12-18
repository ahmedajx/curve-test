<?php

namespace Tests\App\Services;

use App\Helpers\DateHelper;
use App\Services\ExchangeCalculatorService;
use App\Services\ExchangeService;
use TestCase;

class ExchangeCalculatorServiceTest extends TestCase
{
    private $sut;

    private $exchangeService;

    private $dateHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->exchangeService = \Mockery::mock(ExchangeService::class);
        $this->dateHelper = \Mockery::mock(DateHelper::class);
        $this->sut = new ExchangeCalculatorService($this->exchangeService, $this->dateHelper);
    }

    public function testGetExchangeRateRecommendationWhichIsPositive()
    {
        $this->dateHelper
            ->shouldReceive('getTodayDateInYmd')
            ->once()
            ->andReturn('2019-12-18');

        $this->dateHelper
            ->shouldReceive('getLastWeekDateInYmd')
            ->once()
            ->andReturn('2019-12-11');

        $this->dateHelper
            ->shouldReceive('getYesterdayDateInYmd')
            ->once()
            ->andReturn('2019-12-17');

        $this->exchangeService
            ->shouldReceive('getLatestExchangeRate')
            ->once()
            ->with('USD', '2019-12-11', '2019-12-18')
            ->andReturn("{\"rates\":{\"2019-12-17\":{\"EUR\":0.9029345373},\"2019-12-16\":{\"EUR\":0.8971828459},\"2019-12-11\":{\"EUR\":0.9029345372},\"2019-12-13\":{\"EUR\":0.8949346698},\"2019-12-12\":{\"EUR\":0.8979078747}},\"start_at\":\"2019-12-11\",\"base\":\"USD\",\"end_at\":\"2019-12-18\"}");

        $this->exchangeService
            ->shouldReceive('getLatestExchangeRate')
            ->once()
            ->with('GBP', '2019-12-11', '2019-12-18')
            ->andReturn("{\"rates\":{\"2019-12-17\":{\"EUR\":1.1799688488},\"2019-12-16\":{\"EUR\":1.1988251514},\"2019-12-11\":{\"EUR\":1.1870140661},\"2019-12-13\":{\"EUR\":1.1974900608},\"2019-12-12\":{\"EUR\":1.1825922422}},\"start_at\":\"2019-12-11\",\"base\":\"GBP\",\"end_at\":\"2019-12-18\"}");

        $this->assertEquals("{\"data\":[{\"name\":\"USD\",\"today_rate\":0.9029345373,\"last_week\":0.9029345372,\"exchange_recommendation\":true},{\"name\":\"GBP\",\"today_rate\":1.1799688488,\"last_week\":1.1870140661,\"exchange_recommendation\":false}],\"success\":true}", $this->sut->recommendationCalculator());
    }
}
