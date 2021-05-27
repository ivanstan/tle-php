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
}
