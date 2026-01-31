<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\AndTleSpecification;
use Ivanstan\Tle\Specification\CircularOrbitTleSpecification;
use Ivanstan\Tle\Specification\GeostationaryOrbitTleSpecification;
use Ivanstan\Tle\Specification\LowEarthOrbitTleSpecification;
use Ivanstan\Tle\Specification\NotTleSpecification;
use Ivanstan\Tle\Specification\OrTleSpecification;
use PHPUnit\Framework\TestCase;

class CompositeSpecificationTest extends TestCase
{
    public function testAndSpecificationBothSatisfied(): void
    {
        // ISS is both LEO and has circular orbit
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new AndTleSpecification(
            new LowEarthOrbitTleSpecification(),
            new CircularOrbitTleSpecification()
        );
        
        $this->assertTrue($specification->isSatisfiedBy($tle), 'ISS should satisfy both LEO and circular orbit');
    }

    public function testAndSpecificationOneFails(): void
    {
        // GOES-16 is circular but not LEO
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new AndTleSpecification(
            new LowEarthOrbitTleSpecification(),
            new CircularOrbitTleSpecification()
        );
        
        $this->assertFalse($specification->isSatisfiedBy($tle), 'GOES-16 is circular but not LEO');
    }

    public function testOrSpecificationOneSatisfied(): void
    {
        // GOES-16 is geostationary (not LEO, but satisfies GEO)
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new OrTleSpecification(
            new LowEarthOrbitTleSpecification(),
            new GeostationaryOrbitTleSpecification()
        );
        
        $this->assertTrue($specification->isSatisfiedBy($tle), 'GOES-16 should satisfy LEO OR geostationary');
    }

    public function testOrSpecificationNoneSatisfied(): void
    {
        // TESS is neither LEO nor geostationary
        $tle = new Tle(
            '1 43435U 18038A   21155.76042824 -.00000389  00000-0  00000-0 0  9993',
            '2 43435  28.1373 142.4581 8947273 181.4337 180.8614  0.06516003  1193',
            'TESS'
        );

        $specification = new OrTleSpecification(
            new LowEarthOrbitTleSpecification(),
            new GeostationaryOrbitTleSpecification()
        );
        
        $this->assertFalse($specification->isSatisfiedBy($tle), 'TESS should not satisfy LEO OR geostationary');
    }

    public function testNotSpecification(): void
    {
        // ISS is not geostationary
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new NotTleSpecification(new GeostationaryOrbitTleSpecification());
        
        $this->assertTrue($specification->isSatisfiedBy($tle), 'ISS should satisfy NOT geostationary');
    }

    public function testNotSpecificationInverted(): void
    {
        // GOES-16 is geostationary
        $tle = new Tle(
            '1 41866U 16071A   21155.52066792 -.00000268  00000-0  00000-0 0  9999',
            '2 41866   0.0182 271.3365 0001158 338.3132  95.7577  1.00271127 17212',
            'GOES-16'
        );

        $specification = new NotTleSpecification(new GeostationaryOrbitTleSpecification());
        
        $this->assertFalse($specification->isSatisfiedBy($tle), 'GOES-16 should not satisfy NOT geostationary');
    }

    public function testComplexComposition(): void
    {
        // ISS: LEO, circular, not geostationary
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        // Complex: (LEO AND circular) AND (NOT geostationary)
        $specification = new AndTleSpecification(
            new AndTleSpecification(
                new LowEarthOrbitTleSpecification(),
                new CircularOrbitTleSpecification()
            ),
            new NotTleSpecification(new GeostationaryOrbitTleSpecification())
        );
        
        $this->assertTrue($specification->isSatisfiedBy($tle), 'ISS should satisfy complex composition');
    }
}

