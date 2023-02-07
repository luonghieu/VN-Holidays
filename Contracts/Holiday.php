<?php

namespace App\Libs\Holidays\Contracts;

interface Holiday
{
    /**
     * Returns the name of this holiday.
     *
     * @return string
     */
    public function getCommonName();

    /**
     * Returns the name of this holiday.
     *
     * @return string
     */
    public function getName();

    /**
     * Format the instance as a string using the set format.
     *
     * @return string
     */
    public function getTime();
}
