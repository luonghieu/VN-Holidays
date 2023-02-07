<?php

namespace App\Libs\Holidays\Collectors;

use App\Enums\HolidayType;
use App\Libs\Holidays\Contracts\Collector;
use Carbon\Carbon;
use DB;

class RemovedCollector implements Collector
{
    /**
     * Handle collect.
     *
     * @param int $year
     *
     * @return array
     */
    public function handle(int $year)
    {
        $data = [];

        foreach ($this->getData($year) as $value) {
            $data[] = Carbon::create($year, $value->month, $value->day)
                ->toDateTimeString();
        }

        return $data;
    }

    /**
     * Get data
     *
     * @return mixed
     */
    private function getData($year)
    {
        return DB::table('holidays')
            ->where('type', HolidayType::REMOVED->value)
            ->where('year', $year)
            ->get([
                'year',
                'month',
                'day',
            ]);
    }
}
