A simple weather prophet
========================

[![Build Status](https://travis-ci.org/smoya/weather.in.svg?branch=master)](https://travis-ci.org/smoya/weather.in)

A simple website to check the weather by address.

Demo [here](http://the-weather-in.herokuapp.com)

### Dependencies

This library uses [composer](https://getcomposer.org) to manage the PHP dependencies and [npm](https://www.npmjs.com/) for [bower](http://bower.io).

Composer is included in this project [here](bin/composer.phar).

The dependencies that you should install before run this project are:

* php5-curl
* npm


###Installation

This library is on top of [Silex](http://http://silex.sensiolabs.org).


Just clone this repository and install it via composer.

```
bin/composer.phar install
```

or just use the make file doing

```
make install
```

After that, you should add your API credentials for the geocoder and the weather provider in [config/prod.php](config/prod.php). Note that by default the keys are setted because this project was made for test-only purposes.


```
$app['the_weather_in.geocoder.google.api_key'] = 'api_key_here';
$app['the_weather_in.weather_provider.forecast.api_key'] = 'api_key_here';
```

###Geocoding providers

Only Google Geocoging API is available. Please check the [docs](https://developers.google.com/maps/documentation/geocoding) for more info.

###Weather info providers

Only Forecast.io API is available. Please check the [docs](https://developer.forecast.io) for more info.

###Tests

The tests are organized in:

* Unit
* Integration

####Unit tests
There are few unit tests made with PHPSpec. Just run the following command to run the testsuite.

```
bin/phpspec run
```

or just

```
make specs
```

####Integration tests
There are few integrations tests made with PHPUnit. Just run the following command to run the testsuite.

This tests are using the real 3rd party services to geocode the address and to retrieve the weather info. They are using a real api-key, so please be careful with the rate limits.


```
bin/phpunit
```

or just

```
make integration-tests
```

###To do

* Cache for geocoding + weather requests
* Improve frontend
