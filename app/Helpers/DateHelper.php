<?php

namespace App\Helpers;

use DateTime;

class DateHelper
{

    /**
     * DateHelper constructor.
     */
    public function __construct()
    {
    }

    public function getTodayDateInYmd(): string
    {
        return $this->formatYmd(new DateTime());
    }

    public function getLastWeekDateInYmd(): string
    {
        return $this->formatYmd(new DateTime('7 days ago'));
    }

    private function formatYmd(DateTime $dateTime): string
    {
        return $dateTime->format('Y-m-d');
    }

    public function getYesterdayDateInYmd()
    {
        return $this->formatYmd(new DateTime('1 day ago'));
    }
}
