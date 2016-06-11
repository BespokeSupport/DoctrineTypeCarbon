<?php

namespace BespokeSupport\DoctrineTypeCarbon;

use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * Class CarbonDateTimeTimezoneType
 * @package BespokeSupport\DoctrineTypeCarbon
 */
class CarbonDateTimeTimezoneType extends DateTimeType
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'carbon_datetime';
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return static
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof \DateTime) {
            return Carbon::instance($result);
        }

        return $result;
    }
}
