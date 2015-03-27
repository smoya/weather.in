<?php

namespace TheWeatherIn\Component\Weather;

use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Http\Curl\Client;

class ForecastWeatherInfoProvider implements WeatherInfoProvider
{
    const ENDPOINT_BASE = 'https://api.forecast.io/forecast';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param Client $client
     * @param string $apiKey
     */
    public function __construct(Client $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param Coordinates $coordinates
     *
     * @return array
     */
    public function getInfo(Coordinates $coordinates)
    {
        $endpoint = $this->generateEndPoint(
            $coordinates->getLatitude(),
            $coordinates->getLongitude()
        );

        $response = $this->client->doGet($endpoint);

        $result = json_decode($response, true);
        if (null === $result || (is_array($result) && isset($result['code']))) {
            throw new \InvalidArgumentException('Weather not found for this coordinates');
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'forecast';
    }

    private function generateEndPoint($latitude, $longitude)
    {
        return sprintf(
            '%s/%s/%s,%s',
            self::ENDPOINT_BASE,
            $this->apiKey,
            $latitude,
            $longitude
        );
    }
}
