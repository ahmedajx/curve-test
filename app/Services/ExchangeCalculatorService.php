<?php

namespace App\Services;

use App\Helpers\DateHelper;

class ExchangeCalculatorService
{
    private $exchangeService;

    private $dateHelper;

    /**
     * ExchangeCalculatorService constructor.
     * @param ExchangeService $exchangeService
     * @param DateHelper $dateHelper
     */
    public function __construct(ExchangeService $exchangeService, DateHelper $dateHelper)
    {
        $this->exchangeService = $exchangeService;
        $this->dateHelper = $dateHelper;
    }

    public function recommendationCalculator(): string
    {
        $recommendationBuilder = [];

        $startDate = $this->dateHelper->getLastWeekDateInYmd();
        $endDate = $this->dateHelper->getTodayDateInYmd();
        $yesterdayDate = $this->dateHelper->getYesterdayDateInYmd();

        $exchangeRatesLastWeekForUSD = json_decode($this->exchangeService->getLatestExchangeRate('USD', $startDate, $endDate));
        $exchangeRatesLastWeekForGBP = json_decode($this->exchangeService->getLatestExchangeRate('GBP', $startDate, $endDate));

        $usdRates = (array) $exchangeRatesLastWeekForUSD->rates;
        $gbpRates = (array) $exchangeRatesLastWeekForGBP->rates;

        $usdTodayRate = $this->getRate($usdRates, $endDate, $yesterdayDate)->EUR;
        $usdLastWeekRate = $usdRates[$startDate]->EUR;

        $recommendationBuilder[0]['name'] = 'USD';
        $recommendationBuilder[0]['today_rate'] = $usdTodayRate;
        $recommendationBuilder[0]['last_week'] = $usdLastWeekRate;
        $recommendationBuilder[0]['exchange_recommendation'] = $this->naiveRecommendationAlgorithm($usdTodayRate, $usdLastWeekRate);


        $gbpTodayRate = $this->getRate($gbpRates, $endDate, $yesterdayDate)->EUR;
        $gbpLastWeekRate = $gbpRates[$startDate]->EUR;

        $recommendationBuilder[1]['name'] = 'GBP';
        $recommendationBuilder[1]['today_rate'] = $gbpTodayRate;
        $recommendationBuilder[1]['last_week'] = $gbpLastWeekRate;
        $recommendationBuilder[1]['exchange_recommendation'] = $this->naiveRecommendationAlgorithm($gbpTodayRate, $gbpLastWeekRate);

        return json_encode([
            'data' => $recommendationBuilder,
            'success' => true
        ]);
    }

    private function getRate(array $rates, string $date, string $previousDate): object
    {
        return in_array($date, $rates) ? $rates[$date] : $rates[$previousDate];
    }

    private function naiveRecommendationAlgorithm(float $todayRate, float $lastWeekRate)
    {
        $inc = $todayRate - $lastWeekRate;
        return ($inc / $lastWeekRate) * 100 >= 0;
    }


}
