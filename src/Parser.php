<?php

namespace Ivanstan\Tle;

/**
 * @codeCoverageIgnore
 * @deprecated
 */
class Parser
{
    /**
     * First Line String.
     *
     * @var string
     */
    public $firstLine;

    /**
     * Second Line String.
     *
     * @var string
     */
    public $secondLine;

    /**
     * Twenty-four character name (to be consistent with the name length in the NORAD Satellite Catalog).
     *
     * @var string
     */
    public $name;

    /**
     * Satellite/Catalog Number.
     *
     * @var int
     */
    public $satelliteNumber;

    /**
     * Number of launch in Launch Year
     *
     * @var int
     */
    public $internationalDesignatorLaunchNumber;

    /**
     * Satellite piece. "A" for primary payload. Subsequent lettering indicates secondary payloads and rockets that were
     * directly involved in the launch process or debris detected originating from the primary launch payload.
     *
     * @var string
     */
    public $internationalDesignatorLaunchPiece;

    /**
     * Half of the Mean Motion First Time Derivative, measured in orbits per day per day (orbits/day^2).
     *
     * @var float
     */
    public $meanMotionFirstDerivative;

    /**
     * One sixth the Second Time Derivative of the Mean Motion, measured in orbits per day per day per day
     * (orbits/day3).
     *
     * @var string
     */
    public $meanMotionSecondDerivative;

    /**
     * B-Star Drag Term estimates the effects of atmospheric drag on the satellite's motion.
     *
     * @var string
     */
    public $bStarDragTerm;

    /**
     * Element Set Number is used to distinguish a specific satellite src from its predecessors and successors.
     * Integer value incremented for each calculated src starting with day of launch.
     *
     * @var int
     */
    public $elementNumber;

    /**
     * Orbital inclination.
     *
     * @var string
     */
    public $inclination;

    /**
     * Right Ascension of Ascending Node expressed in degrees (aW0).
     *
     * @var float
     */
    public $rightAscensionAscendingNode;

    /**
     * @var float    Orbit eccentricity (e).
     */
    public $eccentricity;

    /**
     * Argument of Perigee expressed in degrees (w0).
     *
     * @var string
     */
    public $argumentPerigee;

    /**
     * Mean Anomaly M(t).
     *
     * @var string
     */
    public $meanAnomaly;

    /**
     * Mean Motion (n) defined as number of revolutions satellite finished around Earth in one solar day(24 hours).
     *
     * @var float
     */
    public $meanMotion;

    /**
     * Time of one revolution expressed in seconds.
     *
     * @var float
     */
    public $revTime;

    /**
     * Class Constructor.
     *
     * @param $tleString    string    src Data.
     * @param $dateTime        array      DateTime array as result from getdate() function.
     *
     * @throws \Exception
     */
    public function __construct($tleString, $dateTime = null)
    {
        $lines = explode("\n", $tleString);

        $this->firstLine = trim(reset($lines));
        $this->secondLine = trim(end($lines));

        $this->satelliteNumber = (int)substr($this->firstLine, 2, 6);

        $this->internationalDesignatorLaunchNumber = (int)trim(substr($this->firstLine, 12, 2));
        $this->internationalDesignatorLaunchPiece = trim(substr($this->firstLine, 14, 2));

        $this->meanMotionFirstDerivative = trim(substr($this->firstLine, 33, 10));
        $this->meanMotionSecondDerivative = trim(substr($this->firstLine, 44, 8));
        $this->bStarDragTerm = trim(substr($this->firstLine, 53, 8));
        $this->elementNumber = (int)trim(substr($this->firstLine, 64, 4));
        $this->satelliteNumber = (int)trim(substr($this->secondLine, 2, 6));
        $this->inclination = (float)trim(substr($this->secondLine, 8, 8));
        $this->rightAscensionAscendingNode = (float)trim(substr($this->secondLine, 17, 8));
        $this->eccentricity = (float)('.' . trim(substr($this->secondLine, 26, 7)));
        $this->argumentPerigee = (float)trim(substr($this->secondLine, 34, 8));
        $this->meanAnomaly = (float)trim(substr($this->secondLine, 43, 8));
        $this->meanMotion = (float)trim(substr($this->secondLine, 52, 11));
        $this->revTime = $this->meanMotion * Constant::SIDEREAL_DAY_SEC;
    }
}
