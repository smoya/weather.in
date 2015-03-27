<?php

namespace spec\TheWeatherIn\Component\Weather;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Http\Curl\Client;
use TheWeatherIn\Component\Weather\ForecastWeatherInfoProvider;

class ForecastWeatherInfoProviderSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client, 'fake_api_key');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheWeatherIn\Component\Weather\ForecastWeatherInfoProvider');
        $this->shouldImplement('TheWeatherIn\Component\Weather\WeatherInfoProvider');
    }

    function it_has_an_alias()
    {
        $this->getAlias()->shouldReturn('forecast');
    }

    function it_provides_weather_info_from_coordinates(Client $client, Coordinates $coordinates)
    {
        $coordinates->getLatitude()->willReturn(89.99999);
        $coordinates->getLongitude()->willReturn(99.99999);

        $providerResult = '{"fake": "fake"}';
        $expectedEndpoint = sprintf(
            '%s/%s/%s,%s',
            ForecastWeatherInfoProvider::ENDPOINT_BASE,
            'fake_api_key',
            89.99999,
            99.99999
        );

        $client->doGet($expectedEndpoint, null)->willReturn($providerResult)->shouldBeCalled();

        $this->getInfo($coordinates)->shouldReturn(json_decode($providerResult, true));
    }

    function it_throws_an_exception_when_the_weather_can_not_be_retrieved(Client $client, Coordinates $coordinates)
    {
        $coordinates->getLatitude()->willReturn(89.99999);
        $coordinates->getLongitude()->willReturn(99.99999);

        $providerResult = '{"code": "400", "error": "The given location (or time) is invalid."}';
        $expectedEndpoint = sprintf(
            '%s/%s/%s,%s',
            ForecastWeatherInfoProvider::ENDPOINT_BASE,
            'fake_api_key',
            89.99999,
            99.99999
        );

        $client->doGet($expectedEndpoint, null)->willReturn($providerResult)->shouldBeCalled();

        $this->shouldThrow( new \InvalidArgumentException('Weather not found for this coordinates'))->duringGetInfo($coordinates);
    }
}
