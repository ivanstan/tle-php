<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\PolarOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

final class PolarOrbitSpecificationTest extends TestCase
{
    public function testExactInclinationIsTrue(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(90);

        $specification = new PolarOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Assert polar orbit specification is satisfied for 90° inclined orbit');
    }

    public function testOrbitIsNotPolar(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(70);

        $specification = new PolarOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Assert polar orbit specification is not satisfied for 70° inclined orbit');
    }

    public function testOrbitIsPolarWithTolerance(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(88.9);

        $specification = new PolarOrbitTleSpecification(2);
        $this->assertTrue(
            $specification->isSatisfiedBy($tle),
            'Assert polar orbit specification is satisfied for 88.9° inclined orbit with tolerance of 2°'
        );
    }
}
