<?php

namespace App\Tests;

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Model\Tle;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class TleModelTest extends TestCase
{
    public function testParse(): void
    {
        $tle = SampleTleHelper::create();

        static::assertEquals(
            SampleTleHelper::$date,
            $tle->getDate(),
            'Failed asserting TLE returned correct date'
        );

        static::assertEquals(
            43550,
            $tle->getId(),
            'Failed asserting that TLE catalog number is correct'
        );

        static::assertEquals(
            'U',
            $tle->getClassification(),
            'Failed asserting that TLE classification is correct'
        );

        static::assertEquals(
            '1998-067NY',
            $tle->getName(),
            'Assert TLE name is correct'
        );

        static::assertEquals('1998-067NY', $tle->getName(), 'Assert correct name');
        static::assertEquals('1998', $tle->launchYear(), 'Assert correct launch year four digits');
        static::assertEquals('98', $tle->launchYear(false), 'Assert correct launch year two digits');
        static::assertEquals(0.0005785, $tle->eccentricity(), 'Assert correct eccentricity');
        static::assertEquals(67.0956, $tle->argumentOfPerigee(), 'Assert correct argument of perigee');
        static::assertEquals(293.0647, $tle->meanAnomaly(), 'Assert correct mean anomaly');
        static::assertEquals(15.57860024, $tle->meanMotion(), 'Assert correct mean motion');
        static::assertEquals(334.0891, $tle->raan(), 'Assert correct RAAN');
        static::assertEquals(18321.21573649, $tle->epoch(), 'Assert correct epoch');
        self::assertEquals($tle->semiMajorAxis() / 1000, SampleTleHelper::$semiMajorAxis);
        static::assertEquals(
            '1 43550U 98067NY  18321.21573649  .00013513  00000-0  18402-3 0  9990',
            $tle->getLine1(),
            'Assert correct first line'
        );
        static::assertEquals(
            '2 43550  51.6389 334.0891 0005785  67.0956 293.0647 15.57860024 19804',
            $tle->getLine2(),
            'Assert correct second line'
        );

        $class = new ReflectionClass(Tle::class);
        $method = $class->getMethod('getLineByNumber');
        $method->setAccessible(true);

        $this->expectExceptionMessage('Invalid line number 3');
        $method->invokeArgs($tle, [3]);
    }
}
