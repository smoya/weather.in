<?php

namespace test\TheWeatherIn\Integration\Component\Geocoding;

use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Geocoding\GoogleGeocoder;
use TheWeatherIn\Component\Http\Curl\Client;

class GoogleGeocoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GoogleGeocoder
     */
    private $geocoder;

    protected function setUp()
    {
        // This is an api key for test purposes so be careful with the rate limit.
        $testApiKey = 'AIzaSyAbA0oZ8ZDiPZwH7NM8128yXXpQxIIctuA';
        $this->geocoder = new GoogleGeocoder(new Client(), $testApiKey);
    }

    protected function tearDown()
    {
        unset($this->geocoder);
    }

    public function testGeocoding()
    {
        $address = '81 RIVINGTON STREET LONDON EC2A 3AY';
        $result = $this->geocoder->geocode($address);

        $this->assertInstanceOf(Coordinates::class, $result);
        $this->assertEquals(51.5262734, $result->getLatitude());
        $this->assertEquals(-0.0791647, $result->getLongitude());
    }
}
