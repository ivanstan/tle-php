<?php

namespace Ivanstan\Tle\Field;

trait InclinationField
{
    private float $inclination;

    public function getInclination(): float
    {
        return $this->inclination;
    }

    public function setInclination(float $inclination): void
    {
        $this->inclination = $inclination;
    }
}