<?php

namespace Ivanstan\Tle\Model;

use Ivanstan\Tle\Field\InclinationField;
use Ivanstan\Tle\Field\NameField;
use Ivanstan\Tle\Field\TleField;

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
            return $this->formatYear($year);
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

    public function meanMotion(): float
    {
        return (float)trim(substr($this->line2, 52, 11));
    }

    public function getDate(): string
    {
        $year = (int)trim(substr($this->line1, 18, 2));
        $year = $this->formatYear($year);

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

        return $date->format('c');
    }

    public function getChecksum(int $lineNumber): int
    {
        $line = $this->getLineByNumber($lineNumber);

        return (int)trim(substr($line, 68));
    }

    private function formatYear(int $twoDigitYear): int
    {
        if ($twoDigitYear < 57) {
            $twoDigitYear += 2000;
        } else {
            $twoDigitYear += 1900;
        }

        return $twoDigitYear;
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

    public function isGeostationary(): bool
    {
        return (abs($this->meanMotion() - 1.0027) < 0.0002);
    }
}
