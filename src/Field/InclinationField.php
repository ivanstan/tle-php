<?php

namespace Ivanstan\Tle\Field;

use Doctrine\ORM\Mapping as ORM;

trait InclinationField
{
    /**
     * @ORM\Column(type="float", precision=16, scale=10, nullable=true)
     */
    protected float $inclination;

    public function getInclination(): float
    {
        return $this->inclination;
    }

    public function setInclination(float $inclination): void
    {
        $this->inclination = $inclination;
    }
}
