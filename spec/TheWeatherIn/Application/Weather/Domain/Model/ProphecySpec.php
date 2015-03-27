<?php

namespace spec\TheWeatherIn\Application\Weather\Domain\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProphecySpec extends ObjectBehavior
{
    function let()
    {
        $data = ['fake_data'];
        $this->beConstructedWith('foo', $data);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheWeatherIn\Application\Weather\Domain\Model\Prophecy');
    }

    function it_knows_about_its_provider_alias()
    {
        $this->getProviderAlias()->shouldReturn('foo');
    }

    function it_knows_about_its_data()
    {
        $this->getData()->shouldReturn(['fake_data']);
    }

    function it_throws_an_exception_on_construct_when_data_is_empty()
    {
        $this->shouldThrow(new \InvalidArgumentException('Prophecy data can not be empty'))
            ->during('__construct', ['foo', []]);
    }
}
