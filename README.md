# TLE PHP

Client for NASA TLE API (http://api.nasa.gov/) and TLE framework implemented in php.

# About

The TLE API provides up to date two line element set records, the data is updated daily from [CelesTrak](https://celestrak.com/) and served in JSON format. A two-line element set (TLE) is a data format encoding a list of orbital elements of an Earth-orbiting object for a given point in time. For more information on TLE data format visit [Definition of Two-line Element Set Coordinate System](https://spaceflight.nasa.gov/realdata/sightings/SSapplications/Post/JavaSSOP/SSOP_Help/tle_def.html).

#Usage
```
use Ivanstan\Tle\Api;

$client = new Api();

$tle = $client->get(25544);

$tle->getLine1();
$tle->getLine2();
```
