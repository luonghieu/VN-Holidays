<?php

namespace App\Libs\Holidays\Converters;

class Solar
{
    /** @var int */
    public int $year;

    /** @var int */
    public int $month;

    /** @var int */
    public int $day;

    /**
     * Create
     *
     * @return mixed
     */
    public static function create(int $year, int $month, int $day): Solar
    {
        $obj = new static();
        $obj->year = $year;
        $obj->month = $month;
        $obj->day = $day;

        return $obj;
    }
}
