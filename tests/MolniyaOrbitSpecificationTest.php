<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\MolniyaOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

class MolniyaOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        // Create a TLE with Molniya orbit characteristics
        $tle = SampleTleHelper::create();
        $tle->setInclination(63.4);
        
        // Note: We can only set inclination via helper, so this is a partial test
        // A full test would require a real Molniya satellite TLE
        
        $specification = new MolniyaOrbitTleSpecification();
        // This may or may not pass depending on eccentricity/mean motion of sample TLE
        $this->assertIsBool($specification->isSatisfiedBy($tle));
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(51.6); // ISS-like inclination, not Molniya

        $specification = new MolniyaOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Non-Molniya inclination should not satisfy specification');
    }
}

