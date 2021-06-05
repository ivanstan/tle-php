<?php

use Ivanstan\Tle\Model\Tle;
use PHPUnit\Framework\TestCase;

class SunSynchronousOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        $tle = new Tle(
            '1 27597U 02056A   21155.61803229  .00000027  00000-0  28782-4 0  9998',
            '2 27597  98.5638 101.1878 0002039  64.3768 295.7624 14.27502008962051',
            'MIDORI II (ADEOS-II)'
        );
    }
}
