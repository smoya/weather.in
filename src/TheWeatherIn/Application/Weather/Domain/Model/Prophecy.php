<?php

namespace TheWeatherIn\Application\Weather\Domain\Model;

class Prophecy
{
    /**
     * @var string
     */
    private $providerAlias;

    /**
     * @var array
     */
    private $data;

    /**
     * @param string $providerAlias
     * @param array  $data
     */
    public function __construct($providerAlias, array $data)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Prophecy data can not be empty');
        }

        $this->providerAlias = $providerAlias;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getProviderAlias()
    {
        return $this->providerAlias;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
