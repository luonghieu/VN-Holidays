<?php

namespace App\Libs\Holidays\Contracts;

interface Collector
{
    /**
     * Handling collect data
     *
     * @param int $year
     *
     * @return mixed
     */
    public function handle(int $year);
}
