<?php

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$app['the_weather_in.geocoder.google.api_key'] = 'AIzaSyAbA0oZ8ZDiPZwH7NM8128yXXpQxIIctuA';
$app['the_weather_in.weather_provider.forecast.api_key'] = 'f1075166547015b1fb30eeadb1506c75';
