<?php

use Gousto\RecipeRepository;
use Infrastructure\TransformerFactory;
use League\Fractal\Manager;
use Negotiation\Negotiator;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app['repository.recipe'] = function($app) {

    return new RecipeRepository($app['data.csv']);
};

$app['negotiator'] = function() {
    return new Negotiator();
};

$app['transformer_factory'] = function() {
    return new TransformerFactory();
};

$app['response_serializer'] = function() {
    return new Manager();
};

return $app;
