<?php

namespace Ivanstan\Tle\Service;

/**
 * Modulo 10 checksum calculator.
 */
abstract class ChecksumCalculator
{
    public static function calculate(string $content): int
    {
        $content = substr($content, 0, -1); // remove checksum
        $length = \strlen($content);
        $sum = 0;
        for ($i = 0; $i < $length; $i++) {
            if ($content[$i] === '-') {
                ++$sum;
                continue;
            }

            if (is_numeric($content[$i])) {
                $sum += $content[$i];
            }
        }
        return $sum % 10;
    }
}