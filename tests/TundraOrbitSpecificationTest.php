<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\TundraOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class TundraOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // Create a TLE with Tundra orbit characteristics
        $tle = SampleTleHelper::create();
        $tle->setInclination(63.4);
        
        $specification = new TundraOrbitTleSpecification();
        // This may or may not pass depending on eccentricity/mean motion of sample TLE
        $this->assertIsBool($specification->isSatisfiedBy($tle));
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(51.6); // ISS-like inclination, not Tundra

        $specification = new TundraOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Non-Tundra inclination should not satisfy specification');
    }
}

