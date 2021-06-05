<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use PHPUnit\Framework\TestCase;

class SunSynchronousOrbitSpecification extends TestCase
{
    public function testSpecificationIsSatisfied(): void
    {
        $tle = SampleTleHelper::create();
    }
}
