<?php

namespace spec\TheWeatherIn\Component\Geocoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Geocoding\GoogleGeocoder;
use TheWeatherIn\Component\Http\Curl\Client;

class GoogleGeocoderSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client, 'fake_api_key');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheWeatherIn\Component\Geocoding\GoogleGeocoder');
        $this->shouldImplement('TheWeatherIn\Component\Geocoding\Geocoder');
    }

    function it_geocodes_an_address(Client $client)
    {
        $address = 'Mos Espa, Northern Dune Sea, Tatooine';
        $geocoderResult = '{"results": [{"geometry": {"location": {"lat": 89.9999, "lng": 99.9999}}}]}';

        $client->doGet(GoogleGeocoder::ENDPOINT, [
            'key'     => 'fake_api_key',
            'address' => $address
        ])->willReturn($geocoderResult)->shouldBeCalled();

        $this->geocode($address)->shouldBeAnInstanceOf(Coordinates::class);
    }

    function it_throws_an_exception_when_the_address_can_not_be_geocoded(Client $client)
    {
        $address = 'Gol, Vulcan';
        $geocoderResult = '{}';

        $client->doGet(GoogleGeocoder::ENDPOINT, [
            'key'     => 'fake_api_key',
            'address' => $address
        ])->willReturn($geocoderResult);

        $this->shouldThrow(new \InvalidArgumentException('This address could not be geocoded'))->duringGeocode($address);
    }
}
