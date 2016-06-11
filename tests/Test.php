<?php

namespace BespokeSupport\DoctrineTypeCarbon\Tests;

use Carbon\Carbon;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Test type that maps an SQL DATETIME/TIMESTAMP to a Carbon/Carbon object.
 *
 * @author Steve Lacey <steve@stevelacey.net>
 */
class Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var null|EntityManager
     */
    public $em = null;

    public static function setUpBeforeClass()
    {
        Type::addType('CarbonDate', 'BespokeSupport\DoctrineTypeCarbon\CarbonDateType');
        Type::addType('CarbonDateTime', 'BespokeSupport\DoctrineTypeCarbon\CarbonDateTimeType');
        Type::addType('CarbonDateTimeTimezone', 'BespokeSupport\DoctrineTypeCarbon\CarbonDateTimeTimezoneType');
        Type::addType('CarbonTime', 'BespokeSupport\DoctrineTypeCarbon\CarbonTimeType');
    }

    public function setUp()
    {
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(__DIR__ . '/Proxies');
        $config->setProxyNamespace('BespokeSupport\DoctrineTypeCarbon');
        $config->setAutoGenerateProxyClasses(true);
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(__DIR__ . '/../src'));

        $this->em = EntityManager::create(
            array(
                'driver' => 'pdo_sqlite',
                'memory' => true,
            ),
            $config
        );

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema(array(
            $this->em->getClassMetadata('BespokeSupport\DoctrineTypeCarbon\Tests\TestEntity'),
        ));

        $entity = new TestEntity();
        $entity->id = 1;
        $entity->date        = Carbon::createFromDate(2015, 1, 1);
        $entity->datetime    = Carbon::create(2015, 1, 1, 0, 0, 0);
        $entity->datetime_tz = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');
        $entity->time        = Carbon::createFromTime(12, 0, 0, 'Europe/London');
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateGetter()
    {
        $entity = $this->em->find('BespokeSupport\DoctrineTypeCarbon\Tests\TestEntity', 1);
var_dump($entity);
        $this->assertInstanceOf('Carbon\Carbon', $entity->date);
        $this->assertEquals(Carbon::createFromDate(2015, 1, 1), $entity->date);
    }

    public function testDateSetter()
    {
        $entity = new TestEntity();
        $entity->id = 2;
        $entity->date = Carbon::createFromDate(2015, 1, 1);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateTimeGetter()
    {
        $entity = $this->em->find('BespokeSupport\DoctrineTypeCarbon\Tests\TestEntity', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->datetime);
        $this->assertEquals(Carbon::create(2015, 1, 1, 0, 0, 0), $entity->datetime);
    }

    public function testDateTimeSetter()
    {
        $entity = new TestEntity();
        $entity->id = 2;
        $entity->datetime = Carbon::create(2015, 1, 1, 0, 0, 0);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testDateTimeTzGetter()
    {
        $entity = $this->em->find('BespokeSupport\DoctrineTypeCarbon\Tests\TestEntity', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->datetime_tz);
        $this->assertEquals(Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific'), $entity->datetime_tz);
    }

    public function testDateTimeTzSetter()
    {
        $entity = new TestEntity();
        $entity->id = 2;
        $entity->datetime_tz = Carbon::create(2012, 1, 1, 0, 0, 0, 'US/Pacific');

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function testTimeGetter()
    {
        $entity = $this->em->find('BespokeSupport\DoctrineTypeCarbon\Tests\TestEntity', 1);

        $this->assertInstanceOf('Carbon\Carbon', $entity->time);
        $this->assertEquals(Carbon::createFromTime(12, 0, 0, 'Europe/London'), $entity->time);
    }

    public function testTimeSetter()
    {
        $entity = new TestEntity();
        $entity->id = 2;
        $entity->time = Carbon::createFromTime(12, 0, 0, 'Europe/London');

        $this->em->persist($entity);
        $this->em->flush();
    }
}
