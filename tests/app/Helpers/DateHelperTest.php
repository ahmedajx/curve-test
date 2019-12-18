<?php

namespace Tests\App\Helpers;

use App\Helpers\DateHelper;
use DateTime;
use TestCase;

class DateHelperTest extends TestCase
{
    private $sut;

    public function setUp():void
    {
        parent::setUp();

        $this->sut = new DateHelper();
    }

    public function testGettingTodayDateInYmd()
    {
        $todayDate = new DateTime();
        $this->assertEquals($todayDate->format('Y-m-d'), $this->sut->getTodayDateInYmd());
    }

    public function testGettingLastWeekDateInYmd()
    {
        $todayDate = new DateTime('7 days ago');
        $this->assertEquals($todayDate->format('Y-m-d'), $this->sut->getLastWeekDateInYmd());
    }

    public function testGettingYesterdayDateInYmd()
    {
        $yesterdayDate = new DateTime('1 day ago');
        $this->assertEquals($yesterdayDate->format('Y-m-d'), $this->sut->getYesterdayDateInYmd());
    }

}
