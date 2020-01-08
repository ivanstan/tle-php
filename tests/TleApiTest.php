<?php

use Ivanstan\Tle\Model\Tle;
use Ivanstan\Tle\Api;
use PHPUnit\Framework\TestCase;

class TleApiTest extends TestCase
{
    public function testApiReturnsCorrectRecord(): void
    {
        $api = new Api();

        $this->assertInstanceOf(Tle::class, $api->get(43553), 'Assert Api get record returns Tle instance');
    }
}