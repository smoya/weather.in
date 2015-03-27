<?php

namespace TheWeatherIn\Component\Geocoding;

use TheWeatherIn\Component\Http\Curl\Client;

class GoogleGeocoder implements Geocoder
{
    const ENDPOINT = 'https://maps.googleapis.com/maps/api/geocode/json';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(Client $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $address
     *
     * @return Coordinates
     */
    public function geocode($address)
    {
        $response = $this->client->doGet(
            self::ENDPOINT,
            [
                'key'     => $this->apiKey,
                'address' => $address,
            ]
        );

        $result = json_decode($response, true);
        if (null === $result || (is_array($result) && !isset($result['results']))) {
            throw new \InvalidArgumentException('This address could not be geocoded');
        }

        $info = array_pop($result['results']);
        $latitude = $info['geometry']['location']['lat'];
        $longitude = $info['geometry']['location']['lng'];

        return new Coordinates($latitude, $longitude);
    }
}
