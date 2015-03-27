<?php

namespace TheWeatherIn\Component\Http\Curl;

/**
 * This is a lightweight implementation of a curl client.
 */
class Client
{
    /**
     * @param int   $url
     * @param array $parameters
     * @param int   $timeout    Time in ms
     *
     * @return string The response content
     */
    public function doGet($url, array $parameters = null, $timeout = null)
    {
        $endpoint = $this->constructEndPoint($url, $parameters);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (null !== $timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * @param string $url
     * @param array  $parameters
     *
     * @return string
     */
    private function constructEndPoint($url, array $parameters = null)
    {
        if (null === $parameters) {
            return $url;
        }

        array_walk(
            $parameters,
            function (&$value, $key) {
                $value = $key.'='.urlencode($value);
            }
        );

        $parameterizedUrl = $url.'?'.implode('&', $parameters);

        return $parameterizedUrl;
    }
}
