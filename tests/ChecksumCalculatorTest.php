<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Service\ChecksumCalculator;
use PHPUnit\Framework\TestCase;

final class ChecksumCalculatorTest extends TestCase
{
    public function testCalculatedChecksumIsCorrect(): void
    {
        $tle = SampleTleHelper::create();

        $this->assertEquals(
            $tle->getChecksum(Tle::LINE1),
            ChecksumCalculator::calculate($tle->getLine1()),
            'Assert checksum calculator returned correct value'
        );
    }
}