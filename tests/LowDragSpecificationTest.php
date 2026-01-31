<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\LowDragTleSpecification;
use PHPUnit\Framework\TestCase;

class LowDragSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // GOES-16 has BSTAR of 0 (geostationary, no atmospheric drag)
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new LowDragTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Geostationary satellite should have low drag');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        // ISS has relatively high BSTAR due to low altitude and atmospheric drag
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        // Use a very low threshold that ISS won't meet
        $specification = new LowDragTleSpecification(0.00001);
        $this->assertFalse($specification->isSatisfiedBy($tle), 'ISS should not satisfy low drag specification with strict threshold');
    }
}

