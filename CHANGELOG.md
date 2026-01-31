# Changelog

All notable changes to this project will be documented in this file.

## [2.0.0] - 2026-01-02

### Breaking Changes

- **PHP 8.4 Required** - Minimum PHP version bumped from 8.0 to 8.4
- **Native Enums** - Replaced class-based enums with PHP 8.1+ native enums:
  - `OrbitDirectionEnum` - now a backed enum with `POSIGRADE` and `RETROGRADE` cases
  - `SatelliteClassificationEnum` - now a backed enum with `UNCLASSIFIED`, `CLASSIFIED`, and `SECRET` cases

### Added

- **Sun-Synchronous Orbit Specification** - New `SunSynchronousOrbitTleSpecification` class to identify satellites in sun-synchronous orbits based on nodal precession rate (~0.9856°/day)
- Configurable tolerance parameter for sun-synchronous orbit detection

### Changed

- Updated PHPUnit from 9.x to 11.x
- Modernized PHPUnit configuration (`phpunit.xml`) for PHPUnit 11 compatibility
- Updated Guzzle HTTP client to ^7.10
- Improved test scripts in `composer.json`:
  - `composer test` - runs tests without coverage
  - `composer test:coverage` - runs tests with code coverage (requires Xdebug)

### Fixed

- Fixed deprecated PHPUnit configuration warnings
- Corrected precession calculation in `SunSynchronousOrbitTleSpecification` to properly use radians for trigonometric functions

## [1.0.3] - Previous Release

See git history for earlier changes.





