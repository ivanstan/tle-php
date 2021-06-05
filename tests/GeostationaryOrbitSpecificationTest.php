<?php

use Ivanstan\Tle\Model\Tle;
use PHPUnit\Framework\TestCaseTest;

class GeostationaryOrbitSpecificationTest extends TestCaseTest {

    public function testSpecificationIsSatisfied(): void
    {
        $tle = new Tle(
            '1 24786U 97019A   21155.72351740  .00000066  00000-0  00000-0 0  9998',
            '2 24786  10.9975  32.9857 0023848 192.2435 350.7348  0.99121401 87849',
            'GOES-10'
        );
    }

}



