<?php

namespace BespokeSupport\DoctrineTypeCarbon;

use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateType;


/**
 * Class CarbonDateType
 * @package BespokeSupport\DoctrineTypeCarbon
 */
class CarbonDateType extends DateType
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'carbon_date';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Carbon|false
     * @throws ConversionException
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
