<?php

namespace BespokeSupport\DoctrineTypeCarbon;

use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TimeType;


/**
 * Class CarbonTimeType
 * @package BespokeSupport\DoctrineTypeCarbon
 */
class CarbonTimeType extends TimeType
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'carbon_time';
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
