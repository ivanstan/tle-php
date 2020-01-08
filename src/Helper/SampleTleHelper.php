<?php

namespace Ivanstan\Tle\Helper;

use Ivanstan\Tle\Model\Tle;

abstract class SampleTleHelper
{
    public static int $id = 43550;
    public static string $name = '1998-067NY';
    public static string $line1 = '1 43550U 98067NY  18321.21573649  .00013513  00000-0  18402-3 0  9990';
    public static string $line2 = '2 43550  51.6389 334.0891 0005785  67.0956 293.0647 15.57860024 19804';
    public static string $date = '2018-11-17T05:10:39+00:00';

    public static function create(): Tle
    {
        return new Tle(self::$line1, self::$line2, self::$name);
    }
}