<?php

namespace Ivanstan\Tle\Enum;

use MyCLabs\Enum\Enum;

class SatelliteClassificationEnum extends Enum
{
    public const UNCLASSIFIED = 'U';
    public const CLASSIFIED = 'C';
    public const SECRET = 'S';
}