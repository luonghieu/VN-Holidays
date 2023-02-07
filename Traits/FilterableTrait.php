<?php

namespace App\Libs\Holidays\Traits;

use App\Libs\Holidays\Filters\Between;
use App\Libs\Holidays\Filters\GreaterThan;
use App\Libs\Holidays\Filters\LessThan;
use App\Libs\Holidays\Filters\NotBetween;
use DateTimeInterface;
use InvalidArgumentException;

trait FilterableTrait
{
    /**
     * Between
     *
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     *
     * @return $this
     */
    public function between(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        $this->verifyDates($startDate, $endDate);

        $this->collection = (new Between([$startDate, $endDate], $this->collection))->getFilteredData();

        return $this;
    }

    /**
     * Not between
     *
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     *
     * @return $this
     */
    public function notBetween(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        $this->verifyDates($startDate, $endDate);

        $this->collection = (new NotBetween([$startDate, $endDate], $this->collection))->getFilteredData();

        return $this;
    }

    /**
     * Greater than
     *
     * @param DateTimeInterface $date
     *
     * @return $this
     */
    public function greaterThan(DateTimeInterface $date)
    {
        $this->collection = (new GreaterThan([$date], $this->collection))->getFilteredData();

        return $this;
    }

    /**
     * Less than
     *
     * @param DateTimeInterface $date
     *
     * @return $this
     */
    public function lessThan(DateTimeInterface $date)
    {
        $this->collection = (new LessThan([$date], $this->collection))->getFilteredData();

        return $this;
    }

    /**
     * Greater than equal
     *
     * @param DateTimeInterface $date
     *
     * @return $this
     */
    public function greaterThanEqual(DateTimeInterface $date)
    {
        $this->collection = (new GreaterThan([$date], $this->collection, true))->getFilteredData();

        return $this;
    }

    /**
     * Less than equal
     *
     * @param DateTimeInterface $date
     *
     * @return $this
     */
    public function lessThanEqual(DateTimeInterface $date)
    {
        $this->collection = (new LessThan([$date], $this->collection, true))->getFilteredData();

        return $this;
    }

    /**
     * Verify dates
     *
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface $endDate
     *
     * @return void
     */
    private function verifyDates(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        if ($startDate > $endDate) {
            throw new InvalidArgumentException('Start date must be a date before the end date.');
        }
    }
}
