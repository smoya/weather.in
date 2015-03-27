<?php

namespace TheWeatherIn\Component\Geocoding;

interface Geocoder
{
    /**
     * @param string $address
     * @return Coordinates|null
     */
    public function geocode($address);
}