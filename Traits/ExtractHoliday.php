<?php

namespace App\Libs\Holidays\Traits;

use App\Libs\Holidays\Collectors\DefaultCollector;
use App\Libs\Holidays\Collectors\AddedCollector;
use App\Libs\Holidays\Collectors\RemovedCollector;
use App\Libs\Holidays\Contracts\Holiday;
use Carbon\Carbon;
use Exception;

trait ExtractHoliday
{
    /**
     * Get holiday dates.
     *
     * @param ?int $year
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function initHolidays(?int $year = null)
    {
        $this->year = $year ?? date('Y');

        $this->clearHolidays();
        $this->addHolidays(resolve(DefaultCollector::class)->handle($this->year));
        $this->addHolidays(resolve(AddedCollector::class)->handle($this->year));
        $this->removeHolidays(resolve(RemovedCollector::class)->handle($this->year));

        return $this;
    }

    /**
     * Add holiday
     *
     * @param Holiday $holiday
     *
     * @return mixed
     */
    private function addHoliday(Holiday $holiday)
    {
        array_push($this->collection, $holiday);
        return $this;
    }

    /**
     * Add holidays
     *
     * @param array $holidays
     *
     * @return mixed
     */
    private function addHolidays(array $holidays)
    {
        $this->collection = array_merge($this->collection, $holidays);
        return $this;
    }

    /**
     * Remove holidays
     *
     * @param array $holidays
     *
     * @return mixed
     */
    public function removeHolidays(array $holidays)
    {
        $this->collection = array_diff_key(
            $this->collection,
            array_flip($holidays)
        );

        return $this;
    }

    /**
     * Gets all the holiday dates
     *
     * @param int|null $year
     *
     * @return array
     *
     * @throws Exception
     */
    public function getHolidayDates(?int $year = null)
    {
        if (!$this->year || $this->year !== $year || !$this->collection) {
            $this->initHolidays($year);
        }

        return array_map(function ($holiday) {
            return (string)$holiday;
        }, $this->collection);
    }

    /**
     * Check is holiday
     *
     * @param ?string $date           Date
     * @param bool    $isCheckWeekend Ignore weekend or not
     *
     * @return bool
     */
    public function isHoliday(?string $date = null, bool $isCheckWeekend = true)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();

        if (in_array($date->toDateString(), $this->getHolidayDates($date->format('Y')))) {
            return true;
        }
        if ($date->isWeekend() && $isCheckWeekend) {
            return true;
        }

        return false;
    }

    /**
     * Get normal date
     *
     * @param ?string $date           Date
     * @param bool    $next           Is next
     * @param bool    $isCheckWeekend Is check weekend
     *
     * @return mixed
     */
    public function getNormalDate(?string $date = null, bool $next = true, bool $isCheckWeekend = true)
    {
        $date = $date ? Carbon::parse($date) : Carbon::now();

        while ($this->isHoliday($date, $isCheckWeekend)) {
            if ($next) {
                $date->addDay();
            } else {
                $date->subDay();
            }
        }

        return $date;
    }
}
