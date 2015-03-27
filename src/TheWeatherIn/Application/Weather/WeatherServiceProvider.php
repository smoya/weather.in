<?php

namespace TheWeatherIn\Application\Weather;

use Silex\Application;
use Silex\ServiceProviderInterface;
use TheWeatherIn\Application\Weather\Domain\Service\Prophet;
use TheWeatherIn\Component\Geocoding\GoogleGeocoder;
use TheWeatherIn\Component\Http\Curl\Client;
use TheWeatherIn\Component\Weather\ForecastWeatherInfoProvider;

class WeatherServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['the_weather_in.client.default'] = $app->share(
            function () use ($app) {
                return new Client();
            }
        );

        $app['the_weather_in.geocoder.default'] = $app->share(
            function () use ($app) {
                return new GoogleGeocoder(
                    $app['the_weather_in.client.default'],
                    $app['the_weather_in.geocoder.google.api_key']
                );
            }
        );

        $app['the_weather_in.weather_provider.default'] = $app->share(
            function () use ($app) {
                return new ForecastWeatherInfoProvider(
                    $app['the_weather_in.client.default'],
                    $app['the_weather_in.weather_provider.forecast.api_key']
                );
            }
        );

        $app['the_weather_in.prophet'] = $app->share(
            function () use ($app) {
                return new Prophet(
                    $app['the_weather_in.geocoder.default'],
                    $app['the_weather_in.weather_provider.default']
                );
            }
        );
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
    }
}
