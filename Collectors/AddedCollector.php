<?php

namespace App\Libs\Holidays\Collectors;

use App\Enums\HolidayType;
use App\Libs\Holidays\Contracts\Collector;
use App\Libs\Holidays\Repositories\Holiday;
use Carbon\Carbon;
use Exception;
use DB;

class AddedCollector implements Collector
{
    /**
     * Handle collect.
     *
     * @param int $year
     *
     * @return array
     *
     * @throws Exception
     */
    public function handle(int $year)
    {
        $data = [];

        foreach ($this->getData($year) as $value) {
            $date =  Carbon::create($year, $value->month, $value->day);
            $data[(string) $date] = new Holiday(
                $value->common_name,
                $value->name,
                $date
            );
        }

        return $data;
    }

    /**
     * Get data
     *
     * @return mixed
     */
    private function getData(int $year)
    {
        return DB::table('holidays')
            ->where('type', HolidayType::ADDED->value)
            ->where('year', $year)
            ->get([
                'common_name',
                'name',
                'year',
                'month',
                'day',
            ]);
    }
}
