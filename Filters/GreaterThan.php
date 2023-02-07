<?php

namespace App\Libs\Holidays\Filters;

use App\Libs\Holidays\Contracts\Filter;
use App\Libs\Holidays\Contracts\Holiday;

class GreaterThan extends AbstractFilter implements Filter
{
    /** @var array */
    private array $collection = [];

    /** @var array */
    private array $filteredData = [];

    /** @var bool */
    private bool $equal;

    /**
     * GreaterThan constructor.
     * @param array $dates
     * @param array $collection
     * @param bool $equal
     */
    public function __construct(array $dates, array $collection, bool $equal = false)
    {
        parent::__construct($dates);
        $this->collection = $collection;
        $this->equal = $equal;
        $this->filterRule()->sortData();
    }

    /**
     * @return mixed
     */
    public function filterRule()
    {
        $this->filteredData = array_filter($this->collection, function (Holiday $holiday) {
            if ($this->equal) {
                return $holiday->getTimestamp() >= $this->getStartDate()->getTimestamp();
            }
            return $holiday->getTimestamp() > $this->getStartDate()->getTimestamp();
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
