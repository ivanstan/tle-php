<?php

namespace Ivanstan\Tle\Specification;

use Ivanstan\Tle\Model\Tle;

/**
 * Recent TLE specification.
 * 
 * Verifies that the TLE epoch is within a specified number of days from the reference date.
 * Stale TLEs produce inaccurate orbital predictions, so this specification helps
 * ensure data freshness for time-critical applications.
 */
class RecentTleTleSpecification implements TleSpecificationInterface
{
    protected int $maxDays;
    protected ?\DateTime $referenceDate;

    /**
     * @param int $maxDays Maximum number of days since TLE epoch (default 30)
     * @param \DateTime|null $referenceDate Reference date to compare against (default: now)
     */
    public function __construct(int $maxDays = 30, ?\DateTime $referenceDate = null)
    {
        $this->maxDays = $maxDays;
        $this->referenceDate = $referenceDate;
    }

    public function isSatisfiedBy(Tle $tle): bool
    {
        $referenceDate = $this->referenceDate ?? new \DateTime('now', new \DateTimeZone('UTC'));
        $epochDate = $tle->epochDateTime();
        
        $daysDifference = abs($referenceDate->diff($epochDate)->days);
        
        return $daysDifference <= $this->maxDays;
    }
}

