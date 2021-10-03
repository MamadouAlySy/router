<?php

use MamadouAlySy\RouteCollectionFactory;

it('cant create a valid route collection object with an array of routes', function () {
    $routes = [
       'home' => [
           'path' => '/',
           'action' => 'HomeController::index',
           'methods' => ['GET']
       ]
    ];

    $routeCollection = RouteCollectionFactory::create($routes);

    $route = $routeCollection->findRouteThatMatches('GET', '/');

    expect($route)->toBeInstanceOf(\MamadouAlySy\Route::class);
    expect($route->getPath())->toBe('/');
    expect($route->getName())->toBe('home');
    expect($route->getAction())->toBe('HomeController::index');
});