<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\PosigradeOrbitTleSpecification;
use PHPUnit\Framework\TestCase;

final class PosigradeOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(78);

        $specification = new PosigradeOrbitTleSpecification();
        self::assertTrue($specification->isSatisfiedBy($tle), 'Assert posigrade orbit specification is satisfied for 78° inclined orbit');
    }

    public function testSpecificationIsNotSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(120);

        $specification = new PosigradeOrbitTleSpecification();
        self::assertFalse($specification->isSatisfiedBy($tle), 'Assert posigrade orbit specification is not satisfied for 120° inclined orbit (retrograde)');
    }

    public function testSpecificationIsNotSatisfiedForPolarOrbit(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(90);

        $specification = new PosigradeOrbitTleSpecification();
        self::assertFalse($specification->isSatisfiedBy($tle), 'Assert posigrade orbit specification is not satisfied for 90° inclined orbit (polar)');
    }
}
