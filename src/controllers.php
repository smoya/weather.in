<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TheWeatherIn\Application\Weather\Domain\Service\Prophet;

$app->get('/', function () use ($app) {
    $form = $app['form.factory']->createBuilder('form')->add('address')->getForm();

    return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
})->bind('homepage');

$app->post('/weather', function (Request $request) use ($app) {
    $form = $app['form.factory']->createBuilder('form')->add('address')->getForm();
    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

        /** @var Prophet $prophet */
        $prophet = $app['the_weather_in.prophet'];
        $prophecy = $prophet->prophesy($data['address']);

        return $app['twig']->render('weather.html.twig', ['prophecy' => $prophecy]);
    }

    return $app['twig']->render('index.html.twig', array('form' => $form->createView()));
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $template = 'errors/404.html.twig';
            break;
        case 500:
            $template = 'errors/500.html.twig';
            break;
        default:
            $template = 'errors/default.html.twig';
            break;
    }

    return new Response($app['twig']->render($template, ['code' => $code]), $code);
});

