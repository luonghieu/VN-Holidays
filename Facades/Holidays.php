<?php

namespace App\Libs\Holidays\Facades;

use Illuminate\Support\Facades\Facade;

class Holidays extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Holidays';
    }
}
