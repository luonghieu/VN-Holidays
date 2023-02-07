<?php

namespace App\Libs\Holidays\Repositories;

use App\Libs\Holidays\Contracts\Holiday as BaseHoliday;
use DateTimeInterface;
use DateTimeZone;
use DateTime;
use Exception;
use JsonSerializable;

class Holiday extends DateTime implements BaseHoliday, JsonSerializable
{
    /**
     * @var string common name (internal name) of this holiday
     */
    protected string $commonName;

    /**
     * @var string name (internal name) of this holiday
     */
    protected string $name;

    /**
     * Creates a new Holiday.
     *
     * @param string            $commonName
     * @param string            $name
     * @param DateTimeInterface $date
     *
     * @throws Exception
     */
    public function __construct(
        $commonName,
        $name,
        DateTimeInterface $date
    ) {
        $this->commonName = $commonName;
        $this->name = $name;
        parent::__construct(
            $date->format('Y-m-d'),
            new DateTimeZone(config('app.timezone'))
        );
    }

    /**
     * Returns the common name of this holiday.
     *
     * @return string
     */
    public function getCommonName(): string
    {
        return $this->commonName;
    }

    /**
     * Returns the name of this holiday.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Format the instance as a string using the set format.
     *
     * @return int
     */
    public function getTime()
    {
        return $this->getTimestamp();
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'common_name' => $this->getCommonName(),
            'name' => $this->getName(),
            'date' => $this->format(self::ATOM)
        ];
    }

    /**
     * Format the instance as a string using the set format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d');
    }
}
