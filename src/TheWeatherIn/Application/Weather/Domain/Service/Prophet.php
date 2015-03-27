<?php

namespace TheWeatherIn\Application\Weather\Domain\Service;

use TheWeatherIn\Application\Weather\Domain\Model\Exception\ProphetException;
use TheWeatherIn\Application\Weather\Domain\Model\Prophecy;
use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Geocoding\Geocoder;
use TheWeatherIn\Component\Weather\WeatherInfoProvider;

class Prophet
{
    /**
     * @var Geocoder
     */
    private $geocoder;

    /**
     * @var WeatherInfoProvider
     */
    private $provider;

    /**
     * @param Geocoder $geocoder
     */
    public function __construct(Geocoder $geocoder, WeatherInfoProvider $provider)
    {
        $this->geocoder = $geocoder;
        $this->provider = $provider;
    }

    /**
     * @param string $address
     *
     * @return Prophecy
     */
    public function prophesy($address)
    {
        $coordinates = $this->geocoder->geocode($address);
        if (!$coordinates instanceof Coordinates) {
            throw new ProphetException('Are you sure you are where you said?');
        }

        $weatherInfo = $this->provider->getInfo($coordinates);
        if (!is_array($weatherInfo) || empty($weatherInfo)) {
            throw new ProphetException('Sorry but today the gods refused me the power');
        }

        return new Prophecy($this->provider->getAlias(), $weatherInfo);
    }
}
