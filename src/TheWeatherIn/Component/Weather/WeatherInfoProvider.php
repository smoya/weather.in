<?php

namespace TheWeatherIn\Component\Weather;

use TheWeatherIn\Component\Geocoding\Coordinates;

interface WeatherInfoProvider
{
    /**
     * @param Coordinates $coordinates
     * @return array
     */
    public function getInfo(Coordinates $coordinates);

    /**
     * @return string
     */
    public function getAlias();
}