<?php

namespace test\TheWeatherIn\Integration\Component\Weather;

use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Http\Curl\Client;
use TheWeatherIn\Component\Weather\ForecastWeatherInfoProvider;

class ForecastWeatherInfoProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ForecastWeatherInfoProvider
     */
    private $provider;

    protected function setUp()
    {
        // This is an api key for test purposes so be careful with the rate limit.
        $testApiKey = 'f1075166547015b1fb30eeadb1506c75';
        $this->provider = new ForecastWeatherInfoProvider(new Client(), $testApiKey);
    }

    protected function tearDown()
    {
        unset($this->provider);
    }

    public function testWeatherProviderReturnsAWeatherProphecy()
    {
        $latitude = 51.5262734;
        $longitude = -0.0791647;
        $weatherInfo = $this->provider->getInfo(new Coordinates($latitude, $longitude));

        $this->assertInternalType('array', $weatherInfo);
        $this->assertArrayHasKey('latitude', $weatherInfo);
        $this->assertArrayHasKey('longitude', $weatherInfo);
        $this->assertEquals($weatherInfo['latitude'], $latitude);
        $this->assertEquals($weatherInfo['longitude'], $longitude);
    }
}
