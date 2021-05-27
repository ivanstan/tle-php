<?php

namespace Ivanstan\Tle\Model;

use Ivanstan\Tle\Enum\Constant;
use Ivanstan\Tle\Field\InclinationField;
use Ivanstan\Tle\Field\NameField;
use Ivanstan\Tle\Field\TleField;
use Ivanstan\Tle\Specification\GeostationaryOrbitTleSpecification;

class Tle
{
    public const LINE1 = 1;
    public const LINE2 = 2;

    use NameField;
    use TleField;
    use InclinationField;

    public function __construct(string $line1, string $line2, ?string $name = null)
    {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->name = $name;

        // calculated fields
        $this->inclination = (float)trim(substr($this->line2, 8, 8));
    }

    public function inclination(): float
    {
        return (float)trim(substr($this->line2, 8, 8));
    }

    public function getId(): int
    {
        return (int)substr($this->line1, 2, 6);
    }

    public function getClassification(): string
    {
        return $this->line1[7];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function launchYear(?bool $fourDigits = true): int
    {
        $year = (int)trim(substr($this->line1, 9, 2));

        if ($fourDigits) {
            return self::twoDigitYearToFourDigitYear($year);
        }

        return $year;
    }

    public static function twoDigitYearToFourDigitYear(int $year): int
    {
        if ($year < 57) {
            $year += 2000;
        } else {
            $year += 1900;
        }

        return $year;
    }

    public function launchNumberOfYear(): int
    {
        return (int)trim(substr($this->line1, 12, 2));
    }

    public function epoch(): string
    {
        return trim(substr($this->line1, 18, 14));
    }

    public function launchPiece(): string
    {
        return trim(substr($this->line1, 14, 2));
    }

    public function bstar(): string
    {
        return trim(substr($this->line1, 53, 8));
    }

    public function elementNumber(): int
    {
        return (int)trim(substr($this->line1, 64, 4));
    }

    public function raan(): float
    {
        return (float)trim(substr($this->line2, 17, 8));
    }

    public function eccentricity(): float
    {
        return (float)('.' . trim(substr($this->line2, 26, 7)));
    }

    public function meanAnomaly(): float
    {
        return (float)trim(substr($this->line2, 43, 8));
    }

    public function argumentOfPerigee(): float
    {
        return (float)trim(substr($this->line2, 34, 8));
    }

    /**
     * @deprecated
     */
    public function getDate(): string
    {
        return $this->epochDateTime()->format('c');
    }

    public function epochDateTime(): \DateTime
    {
        $year = (int)trim(substr($this->line1, 18, 2));
        $year = self::twoDigitYearToFourDigitYear($year);

        $date = new \DateTime();
        $timezone = new \DateTimeZone('UTC');

        $epoch = (float)trim(substr($this->line1, 20, 12));
        $days = (int)$epoch;

        $date
            ->setTimezone($timezone)
            ->setDate($year, 1, $days);

        $faction = round($epoch - $days, 8);

        $faction *= 24; // hours
        $hours = round($faction);
        $faction -= $hours;

        $faction *= 60; // minutes
        $minutes = round($faction);
        $faction -= $minutes;

        $faction *= 60; // seconds
        $seconds = round($faction);
        $faction -= $seconds;

        $faction *= 1000; // milliseconds
        $milliseconds = round($faction);

        $date->setTime($hours, $minutes, $seconds, $milliseconds);

        return $date;
    }

    public function getChecksum(int $lineNumber): int
    {
        $line = $this->getLineByNumber($lineNumber);

        return (int)trim(substr($line, 68));
    }

    private function getLineByNumber(int $lineNumber): string
    {
        if (self::LINE1 === $lineNumber) {
            return $this->line1;
        }

        if (self::LINE2 === $lineNumber) {
            return $this->line2;
        }

        throw new \InvalidArgumentException(\sprintf('Invalid line number %d', $lineNumber));
    }

    /**
     * Seconds for complete orbit
     *
     * @return float
     */
    public function period(): float
    {
        return 86400 / $this->meanMotion();
    }

    /**
     * Revolutions per day
     */
    public function meanMotion(): float
    {
        return (float)trim(substr($this->line2, 52, 11));
    }

    /**
     * @deprecated use GeostationaryOrbitTleSpecification
     */
    public function isGeostationary(): bool
    {
        return (new GeostationaryOrbitTleSpecification())->isSatisfiedBy($this);
    }

    /**
     * @return float semi major axis in meters (a)
     */
    public function semiMajorAxis(): float // meters
    {
        $n = $this->meanMotion() * ((2 * M_PI) / 86400); // rad/s
        $mu = Constant::STANDARD_GRAVITATIONAL_PARAM;

        return ($mu ** (1 / 3)) / ($n ** (2 / 3));
    }

    /**
     * @return float semi minor axis in meters (b)
     */
    public function semiMinorAxis(): float {
        $a = $this->semiMajorAxis();
        $e = $this->inclination();

        return $a * sqrt(1 - ($e ** 2));
    }

    /**
     * @return float semi latus rectum in meters (l)
     */
    public function semiLatusRectum(): float {
        $a = $this->semiMajorAxis();
        $b = $this->semiMinorAxis();

        return ($b ** 2) / $a;
    }
}
