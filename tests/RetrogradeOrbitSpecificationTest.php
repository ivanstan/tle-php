<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\RetrogradeOrbitSpecification;
use PHPUnit\Framework\TestCase;

class RetrogradeOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(120);

        $specification = new RetrogradeOrbitSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Assert retrograde orbit specification is satisfied for 120° inclined orbit');
    }
}