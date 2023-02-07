<?php

namespace App\Libs\Holidays\Filters;

use App\Libs\Holidays\Contracts\Filter;
use App\Libs\Holidays\Contracts\Holiday;

/**
 * Class Between
 * @package Holidays\Filters
 */
class Between extends AbstractFilter implements Filter
{
    /** @var array */
    private array $collection = [];

    /** @var array */
    private array $filteredData = [];

    /**
     * Between constructor.
     * @param array $collection
     * @param array $dates
     */
    public function __construct(array $dates, array $collection)
    {
        parent::__construct($dates);
        $this->collection = $collection;
        $this->filterRule()->sortData();
    }

    /**
     * @return array|mixed
     */
    public function filterRule()
    {
        $this->filteredData = array_filter($this->collection, function (Holiday $holiday) {
            return $holiday->getTimestamp() >= $this->getStartDate()->getTimestamp() &&
                $holiday->getTimestamp() <= $this->getEndDate()->getTimestamp();
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function sortData()
    {
        $this->filteredData = array_values($this->filteredData);

        return $this;
    }

    /**
     * @return array
     */
    public function getFilteredData()
    {
        return $this->filteredData;
    }
}
