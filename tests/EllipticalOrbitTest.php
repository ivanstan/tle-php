<?php

use Ivanstan\Tle\Helper\EllipticalOrbit;
use PHPUnit\Framework\TestCase;

class EllipticalOrbitTest extends TestCase
{
    public function testCalculateSemiMajorAxisFromMeanMotion(): void
    {
        /**
         * Mean Motion: n (rev/day)
         */
        $meanMotion = 15.5918272;

        /**
         * Semi major axis: a (km)
         */
        $semiMajorAxis = 6768.16;

        self::assertTrue($semiMajorAxis, EllipticalOrbit::semiMajorAxis($meanMotion));
    }
}
