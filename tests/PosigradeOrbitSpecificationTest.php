<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Specification\PosigradeOrbitSpecification;
use PHPUnit\Framework\TestCase;

final class PosigradeOrbitSpecificationTest extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
        $tle->setInclination(78);

        $specification = new PosigradeOrbitSpecification();
        $this->assertTrue($specification->isSatisfiedBy($tle), 'Assert posigrade orbit specification is satisfied for 78° inclined orbit');
    }
}