<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\CriticalInclinationOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class CriticalInclinationOrbitSpecificationTest extends TestCase
{
    public function testProgradeInclinationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(63.4);

        $specification = new CriticalInclinationOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Prograde critical inclination (63.4°) should satisfy specification');
    }

    public function testRetrogradeInclinationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(116.6);

        $specification = new CriticalInclinationOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Retrograde critical inclination (116.6°) should satisfy specification');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(51.6);

        $specification = new CriticalInclinationOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Non-critical inclination should not satisfy specification');
    }

    public function testSpecificationWithTolerance(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(64.0); // Slightly off from 63.4°

        $specification = new CriticalInclinationOrbitTleSpecification(1.0);
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Inclination within tolerance should satisfy specification');
    }
}

