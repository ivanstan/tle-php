<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\RetrogradeOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

final class RetrogradeOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(120);

        $specification = new RetrogradeOrbitTleSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Assert retrograde orbit specification is satisfied for 120° inclined orbit');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(45);

        $specification = new RetrogradeOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Assert retrograde orbit specification is not satisfied for 45° inclined orbit (posigrade)');
    }

    public function testSpecificationIsNotSatisfiedForPolarOrbit(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(90);

        $specification = new RetrogradeOrbitTleSpecification();
        $this->assertFalse($specification->isSatisfiedBy($tle), 'Assert retrograde orbit specification is not satisfied for 90° inclined orbit (polar)');
    }
}
