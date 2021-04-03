<?php

namespace Ivanstan\Tle\Enum;

abstract class Constant {

	/**
	 * Time for Earth to make one full rotation.
     * Unit: second
	 */
	public const SIDEREAL_DAY_SEC = 86164.0984;

    /**
     * μ (m3s−2)
     */
	public const STANDARD_GRAVITATIONAL_PARAM = 3.986004418e14;
}
