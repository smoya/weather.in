<?php

namespace spec\TheWeatherIn\Component\Geocoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CoordinatesSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(41.3829912, 2.17254639);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheWeatherIn\Component\Geocoding\Coordinates');
    }

    function it_knows_about_its_latitude()
    {
        $this->getLatitude()->shouldReturn(41.3829912);
    }

    function it_knows_about_its_longitude()
    {
        $this->getLongitude()->shouldReturn(2.17254639);
    }

    function it_throws_an_exception_when_latitude_is_not_a_float()
    {
        $this->shouldThrow(
            new \InvalidArgumentException(
                'The latitude and the longitude should be float values'
            )
        )->during('__construct', ['not_a_float', 2.17254639]);
    }

    function it_throws_an_exception_when_longitude_is_not_a_float()
    {
        $this->shouldThrow(
            new \InvalidArgumentException(
                'The latitude and the longitude should be float values'
            )
        )->during('__construct', [41.3829912, 'not_a_float']);
    }

    function it_throws_an_exception_when_latitude_is_not_a_latitude()
    {
        $this->shouldThrow(
            new \InvalidArgumentException(
                'The latitude should be in the range (-90, 90)'
            )
        )->during('__construct', [-91.3829912, 2.17254639]);
    }

    function it_throws_an_exception_when_longitude_is_not_a_longitude()
    {
        $this->shouldThrow(
            new \InvalidArgumentException(
                'The longitude should be in the range (-180, 180)'
            )
        )->during('__construct', [41.3829912, 181.17254639]);
    }
}
