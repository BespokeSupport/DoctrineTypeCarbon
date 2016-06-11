<?php

namespace BespokeSupport\DoctrineTypeCarbon\Tests;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table
 */
class TestEntity
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /**
     * @Column(type="CarbonDate", nullable=true)
     */
    public $date;

    /**
     * @Column(type="CarbonDateTime", nullable=true)
     */
    public $datetime;

    /**
     * @Column(type="CarbonDateTimeTimezone", nullable=true)
     */
    public $datetime_tz;

    /**
     * @Column(type="CarbonTime", nullable=true)
     */
    public $time;
}
