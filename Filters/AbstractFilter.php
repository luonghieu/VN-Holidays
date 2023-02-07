<?php

namespace App\Libs\Holidays\Filters;

abstract class AbstractFilter
{
    /** @var array */
    private array $dates = [];

    /**
     * Constructor.
     *
     * @param array $dates
     *
     * @return void
     */
    public function __construct(array $dates)
    {
        $this->dates = $dates;
    }

    /**
     * Get start date
     *
     * @return mixed
     */
    public function getStartDate()
    {
        return current($this->dates)->setTime(0, 0, 0);
    }

    /**
     * Get end date
     *
     * @return mixed
     */
    public function getEndDate()
    {
        return current(array_reverse($this->dates))->setTime(23, 59, 59);
    }
}
