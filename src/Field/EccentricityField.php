<?php

namespace Ivanstan\Tle\Field;

use Doctrine\ORM\Mapping as ORM;

trait EccentricityField
{
    /**
     * @ORM\Column(type="float", precision=14, scale=12, nullable=true)
     */
    protected float $eccentricity;

    public function getEccentricity(): float
    {
        return $this->eccentricity;
    }

    public function setEccentricity(float $eccentricity): void
    {
        $this->eccentricity = $eccentricity;
    }
}
