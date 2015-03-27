<?php

namespace spec\TheWeatherIn\Application\Weather\Domain\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TheWeatherIn\Application\Weather\Domain\Model\Exception\ProphetException;
use TheWeatherIn\Application\Weather\Domain\Model\Prophecy;
use TheWeatherIn\Component\Geocoding\Coordinates;
use TheWeatherIn\Component\Geocoding\Geocoder;
use TheWeatherIn\Component\Weather\WeatherInfoProvider;

class ProphetSpec extends ObjectBehavior
{
    function let(Geocoder $geocoder, WeatherInfoProvider $weatherInfoProvider)
    {
        $this->beConstructedWith($geocoder, $weatherInfoProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheWeatherIn\Application\Weather\Domain\Service\Prophet');
    }

    function it_prophesies_the_weather(
        Geocoder $geocoder,
        Coordinates $coordinates,
        WeatherInfoProvider $weatherInfoProvider
    ) {
        $address = 'Mos Espa, Northern Dune Sea, Tatooine';
        $geocoder->geocode($address)->willReturn($coordinates);
        $weatherInfoProvider->getInfo($coordinates)->willReturn(['fake_weather_data']);
        $weatherInfoProvider->getAlias()->willReturn('tatooine_weather');

        $this->prophesy($address)->shouldBeAnInstanceOf(Prophecy::class);
    }

    function it_throws_an_exception_when_the_address_can_not_be_geocoded(Geocoder $geocoder)
    {
        $address = 'Gol, Vulcan';
        $geocoder->geocode($address)->willReturn(null);

        $this->shouldThrow(new ProphetException('Are you sure you are where you said?'))->duringProphesy($address);
    }

    function it_throws_an_exception_when_the_weather_can_not_be_retrieved(
        Geocoder $geocoder,
        Coordinates $coordinates,
        WeatherInfoProvider $weatherInfoProvider
    ) {
        $address = '2, First Street, Moon';
        $geocoder->geocode($address)->willReturn($coordinates);
        $weatherInfoProvider->getInfo($coordinates)->willReturn([]);

        $this->shouldThrow(new ProphetException('Sorry but today the gods refused me the power'))->duringProphesy($address);
    }
}
