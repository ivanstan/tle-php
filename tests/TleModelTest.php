<?php

namespace App\Tests;

use Ivanstan\Tle\Helper\SampleTleHelper;
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
    }
}
