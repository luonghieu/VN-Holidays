<?php

namespace App\Libs\Holidays\Collectors;

use App\Enums\HolidayType;
use App\Libs\Holidays\Contracts\Collector;
use App\Libs\Holidays\Converters\Lunar;
use App\Libs\Holidays\Converters\LunarSolarConverter;
use App\Libs\Holidays\Repositories\Holiday;
use Carbon\Carbon;
use DB;
use Exception;

class DefaultCollector implements Collector
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
        foreach ($this->getData() as $value) {
            $date = $this->convertSolarDay($year, $value);

            $data[(string)$date] = new Holiday(
                $value->common_name,
                $value->name,
                $date
            );
        }

        return $data ?? [];
    }

    /**
     * Get data
     *
     * @return mixed
     */
    private function getData()
    {
        return DB::table('holidays')
            ->where('type', HolidayType::DEFAULT->value)
            ->whereNull('year')
            ->get([
                'common_name',
                'name',
                'year',
                'month',
                'day',
                'is_lunar_day'
            ]);
    }

    /**
     * Convert solar day
     *
     * @return mixed
     */
    private function convertSolarDay($year, $value)
    {
        if ($value->is_lunar_day) {
            $lunar = Lunar::create($year, $value->month, $value->day);
            $solar = LunarSolarConverter::lunarToSolar($lunar);

            return Carbon::create($solar->year, $solar->month, $solar->day);
        }

        return Carbon::create($year, $value->month, $value->day);
    }
}
