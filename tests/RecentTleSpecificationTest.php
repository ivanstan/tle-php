<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Specification\RecentTleTleSpecification;
use PHPUnit\Framework\TestCase;

class RecentTleSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // TLE from June 4, 2021 (day 155 of year 21)
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        // Reference date close to the TLE epoch
        $referenceDate = new \DateTime('2021-06-10', new \DateTimeZone('UTC'));
        
        $specification = new RecentTleTleSpecification(30, $referenceDate);
        $this->assertTrue($specification->isSatisfiedBy($tle), 'TLE within 30 days should satisfy specification');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        // TLE from June 4, 2021
        $tle = new Tle(
            '1 25544U 98067A   21155.52916667  .00002182  00000-0  41420-4 0  9998',
            '2 25544  51.6461 339.8014 0003357  34.4297 125.4396 15.48919393285582',
            'ISS (ZARYA)'
        );

        // Reference date far from the TLE epoch
        $referenceDate = new \DateTime('2022-01-01', new \DateTimeZone('UTC'));
        
        $specification = new RecentTleTleSpecification(30, $referenceDate);
        $this->assertFalse($specification->isSatisfiedBy($tle), 'TLE older than 30 days should not satisfy specification');
    }
}

