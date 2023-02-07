<?php

namespace App\Libs\Holidays\Converters;

class Lunar
{
    /** @var int */
    public int $year;

    /** @var int */
    public int $month;

    /** @var int */
    public int $day;

    /** @var bool */
    public bool $isLeap;

    /**
     * Create
     *
     * @return mixed
     */
    public static function create(int $year, int $month, int $day, bool $isLeap = false): Lunar
    {
        $obj = new static();
        $obj->year = $year;
        $obj->month = $month;
        $obj->day = $day;
        $obj->isLeap = $isLeap;

        return $obj;
    }
}
