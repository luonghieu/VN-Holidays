<?php

namespace App\Libs\Holidays\Repositories;

use App\Libs\Holidays\Contracts\Collection;
use App\Libs\Holidays\Traits\ExtractHoliday;
use App\Libs\Holidays\Traits\FilterableTrait;
use Exception;

class HolidayCollection implements Collection
{
    use FilterableTrait,
        ExtractHoliday;

    /** @var array */
    protected array $collection = [];

    /** @var string */
    protected string $sortField;

    /** @var ?int */
    private ?int $year;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->initHolidays();
    }

    /**
     * Clear all holidays.
     */
    protected function clearHolidays()
    {
        $this->collection = [];
    }

    /**
     * Apply filter
     *
     * @return mixed
     */
    public function applyFilter()
    {
        $this->collection = array_values($this->getCollection());

        return $this;
    }

    /**
     * Order by name
     *
     * @return $this
     */
    public function orderByName()
    {
        $this->sortField = 'getName';
        return $this;
    }

    /**
     * Order by time
     *
     * @return $this
     */
    public function orderByTime()
    {
        $this->sortField = 'getTime';
        return $this;
    }

    /**
     * Ascending
     *
     * @return $this
     */
    public function ascending()
    {
        usort($this->collection, function(Holiday $a, Holiday $b) {
            return $a->{$this->sortField}() > $b->{$this->sortField}();
        });

        return $this;
    }

    /**
     * Descending
     *
     * @return $this
     */
    public function descending()
    {
        usort($this->collection, function(Holiday $a, Holiday $b) {
            return $a->{$this->sortField}() < $b->{$this->sortField}();
        });

        return $this;
    }

    /**
     * Get collection
     *
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * First
     *
     * @return mixed
     */
    public function first()
    {
        return current($this->collection);
    }

    /**
     * Last
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->collection);
    }

    /**
     * Length
     *
     * @return int
     */
    public function length()
    {
        return count($this->collection);
    }

    /**
     * @return array
     */
    public function pluckByName()
    {
        return array_map(function(Holiday $element) {
            return $element->getName();
        }, $this->collection);
    }

    /**
     * @return array
     */
    public function pluckByTime()
    {
        return array_map(function(Holiday $element) {
            return $element->getTime();
        }, $this->collection);
    }
}
