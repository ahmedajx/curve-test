<?php

namespace App\Http\Controllers;

use App\Services\ExchangeCalculatorService;

class ForeignExchangeController extends Controller
{
    private $exchangeCalculatorService;

    /**
     * @param ExchangeCalculatorService $exchangeCalculatorService
     */
    public function __construct(ExchangeCalculatorService $exchangeCalculatorService)
    {
        $this->exchangeCalculatorService = $exchangeCalculatorService;
    }

    public function show()
    {
        return response($this->exchangeCalculatorService->recommendationCalculator(), 200)->header('Content-Type', 'application/json');
    }

}
