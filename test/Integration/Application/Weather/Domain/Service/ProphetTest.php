<?php

namespace test\TheWeatherIn\Integration\Application\Weather\Domain\Service;

use TheWeatherIn\Application\Weather\Domain\Model\Prophecy;
use TheWeatherIn\Application\Weather\Domain\Service\Prophet;
use TheWeatherIn\Component\Geocoding\GoogleGeocoder;
use TheWeatherIn\Component\Http\Curl\Client;
use TheWeatherIn\Component\Weather\ForecastWeatherInfoProvider;

class ProphetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    protected function setUp()
    {
        // Both api keys are for test purposes so be careful with the rate limit.
        $geocoderApiKey = 'AIzaSyAbA0oZ8ZDiPZwH7NM8128yXXpQxIIctuA';
        $weatherProviderApiKey = 'f1075166547015b1fb30eeadb1506c75';

        $client = new Client();
        $geocoder = new GoogleGeocoder($client, $geocoderApiKey);
        $weatherProvider = new ForecastWeatherInfoProvider($client, $weatherProviderApiKey);

        $this->prophet = new Prophet($geocoder, $weatherProvider);
    }

    protected function tearDown()
    {
        unset($this->prophet);
    }

    public function testProphesyTheWeather()
    {
        $address = '81 RIVINGTON STREET LONDON EC2A 3AY';
        $prophecy = $this->prophet->prophesy($address);

        $this->assertInstanceOf(Prophecy::class, $prophecy);
    }
}