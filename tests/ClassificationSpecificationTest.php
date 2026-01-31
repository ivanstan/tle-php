<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\ClassifiedSatelliteTleSpecification;
use Ivanstan\Tle\Specification\UnclassifiedSatelliteTleSpecification;
use PHPUnit\Framework\TestCase;

class ClassificationSpecificationTest extends TestCase
{
    public function testUnclassifiedSpecificationIsSatisfied(): void
    {
        // Standard public TLE has 'U' classification
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new UnclassifiedSatelliteTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Public satellite should satisfy unclassified specification');
    }

    public function testClassifiedSpecificationIsNotSatisfiedForPublic(): void
    {
        // Standard public TLE has 'U' classification
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        $specification = new ClassifiedSatelliteTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Public satellite should not satisfy classified specification');
    }
}

