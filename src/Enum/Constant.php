<?php

namespace Ivanstan\Tle\Enum;

abstract class Constant {

    /**
     * μ (m3s−2)
     */
	public const STANDARD_GRAVITATIONAL_PARAM = 3.986004418e14;

	/**
     * @see https://en.wikipedia.org/wiki/Geopotential_model
     */
	public const SECOND_ZONAL_COEFFICIENT = -0.1082635854e-2;

    /**
     * km
     */
	public const MEAN_EARTH_RADIUS = 6371;
}
