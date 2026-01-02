<?php

namespace Ivanstan\Tle\Enum;

enum SatelliteClassificationEnum: string
{
    case UNCLASSIFIED = 'U';
    case CLASSIFIED = 'C';
    case SECRET = 'S';
}
