<?php

namespace Ivanstan\Tle\Service;

use Ivanstan\Tle\Exception\InvalidTleException;
use Ivanstan\Tle\Model\Tle;

class Validator
{
    private Tle $tle;
    private string $line1 = '';
    private string $line2 = '';

    /**
     * @param Tle $tle
     *
     * @return bool
     * @throws InvalidTleException
     */
    public function validate(Tle $tle): bool
    {
        $this->tle = $tle;
        $this->line1 = $tle->getLine1();
        $this->line2 = $tle->getLine2();

        $this->validLineNumber();
        $this->validChecksum();

        return true;
    }

    /**
     * @throws InvalidTleException
     */
    private function validLineNumber(): void
    {
        if ($this->line1[0] !== (string)Tle::LINE1) {
            throw new InvalidTleException(\sprintf('Line 1 number expected to be %s but %s found', Tle::LINE1, $this->line1[0]));
        }

        if ($this->line2[0] !== (string)Tle::LINE2) {
            throw new InvalidTleException(\sprintf('Line 2 number expected to be %s but %s found', Tle::LINE2, $this->line2[0]));
        }
    }

    /**
     * @throws InvalidTleException
     */
    private function validChecksum(): void
    {
        if ($this->tle->getChecksum(Tle::LINE1) !== ChecksumCalculator::calculate($this->tle->getLine1())) {
            throw new InvalidTleException('Calculated line 1 checksum does not match actual checksum');
        }

        if ($this->tle->getChecksum(Tle::LINE2) !== ChecksumCalculator::calculate($this->tle->getLine2())) {
            throw new InvalidTleException('Calculated line 2 checksum does not match actual checksum');
        }
    }
}