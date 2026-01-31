<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\OrbitalPeriodTleSpecification;
use PHPUnit\Framework\TestCase;

class OrbitalPeriodSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // ISS has ~93 minute orbital period
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        // Typical LEO period range: 88-127 minutes
        $specification = new OrbitalPeriodTleSpecification(88.0, 127.0);
        $this->assertTrue($specification->isSatisfiedBy($tle), 'ISS period should be within LEO range');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        // GOES-16 has ~24 hour orbital period
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        // Typical LEO period range: 88-127 minutes
        $specification = new OrbitalPeriodTleSpecification(88.0, 127.0);
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Geostationary satellite period should not be within LEO range');
    }

    public function testGeostationaryPeriod(): void
    {
        // GOES-16 has ~1440 minute (24 hour) orbital period
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        // GEO period: ~1436 minutes (sidereal day)
        $specification = new OrbitalPeriodTleSpecification(1430.0, 1450.0);
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Geostationary satellite should have ~24 hour period');
    }
}

