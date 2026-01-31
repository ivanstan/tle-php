<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\CircularOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class CircularOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // ISS has very low eccentricity (~0.0003)
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new CircularOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'ISS should satisfy circular orbit specification');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        // TESS has very high eccentricity (~0.89)
        $tle = new Tle(
            '1 43435U 18038A   21155.76042824 -.00000389  00000-0  00000-0 0  9993',
            '2 43435  28.1373 142.4581 8947273 181.4337 180.8614  0.06516003  1193',
            'TESS'
        );

        $specification = new CircularOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Highly elliptical orbit should not satisfy circular orbit specification');
    }

    public function testSpecificationWithCustomTolerance(): void
    {
        // Test with a stricter tolerance
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $strictSpec = new CircularOrbitTleSpecification(0.001);
        $this->assertTrue($strictSpec->isSatisfiedBy($tle), 'ISS should satisfy even strict circular orbit specification');
    }
}

