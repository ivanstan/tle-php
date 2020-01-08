<?php

namespace App\Tests;

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Model\Tle;
use PHPUnit\Framework\TestCase;

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
            0,
            $tle->getChecksum(Tle::LINE1),
            'Failed asserting TLE checksum for line1 is correct'
        );

        static::assertEquals(
            4,
            $tle->getChecksum(Tle::LINE2),
            'Failed asserting TLE checksum for line2 is correct'
        );

        static::assertEquals(
            0,
            $tle->calculateChecksum(Tle::LINE1),
            'Failed asserting TLE calculated checksum for line1 is correct'
        );

        static::assertEquals(
            4,
            $tle->calculateChecksum(Tle::LINE2),
            'Failed asserting TLE calculated checksum for line2 is correct'
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
    }
}
