<?php

namespace TheWeatherIn\Component\Geocoding;

/**
 * Simple value object which represents a map coordinates
 */
class Coordinates
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->validate($latitude, $longitude);

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $latitude
     * @param float $longitude
     */
    private function validate($latitude, $longitude)
    {
        if (!is_float($latitude) || !is_float($longitude)) {
            throw new \InvalidArgumentException(
                'The latitude and the longitude should be float values'
            );
        }

        if ($latitude < -90 || $latitude > 90) {
            throw new \InvalidArgumentException(
                'The latitude should be in the range (-90, 90)'
            );
        }

        if ($longitude < -180 || $longitude > 180) {
            throw new \InvalidArgumentException(
                'The longitude should be in the range (-180, 180)'
            );
        }
    }
}