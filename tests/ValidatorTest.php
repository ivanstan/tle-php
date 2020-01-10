<?php

use Ivanstan\Tle\Helper\SampleTleHelper;
use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Service\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    private Validator $validator;
    private Tle $tle;

    public function setUp(): void
    {
        $this->tle = SampleTleHelper::create();
        $this->validator = new Validator();
    }

    public function testValidateLineNumber(): void
    {
        $tle = SampleTleHelper::create();
        $line = SampleTleHelper::$line1;
        $line[0] = '0';
        $tle->setLine1($line);

        $this->expectExceptionMessage('Line 1 number expected to be 1 but 0 found');
        $this->validator->validate($tle);

        $tle = SampleTleHelper::create();
        $line = SampleTleHelper::$line2;
        $line[0] = '0';
        $tle->setLine2($line);
        $this->expectExceptionMessage('Line 2 number expected to be 2 but 0 found');
        $this->validator->validate($tle);
    }

    public function testValidateLineChecksum(): void
    {
        $line = SampleTleHelper::$line1;
        $line[68] = '0';
        $this->expectExceptionMessage('Calculated line 1 checksum does not match actual checksum');
        $this->validator->validate(new Tle($line, SampleTleHelper::$line2));

        $line = SampleTleHelper::$line2;
        $line[68] = '0';
        $this->expectExceptionMessage('Calculated line 2 checksum does not match actual checksum');
        $this->validator->validate(new Tle(SampleTleHelper::$line1, $line));
    }
}