<?php

use MamadouAlySy\Route;
use MamadouAlySy\Router;

beforeEach(function () {
    $this->router = new Router();
});

it('can add routes', function () {
    $this->router->add(new Route('GET', '/', function () {}));
    $this->router->add(new Route('POST', '/', function () {}));

    expect($this->router->getRoutes('GET'))->toHaveCount(1);
    expect($this->router->getRoutes('POST'))->toHaveCount(1);
});

it('can find route that match a simple url', function () {
    $this->router->add(new Route('GET', '/', function () { return 'test success'; }));
    $route = $this->router->findRouteThatMatches('GET', '/');

    expect($route)->toBeInstanceOf(Route::class);
    expect(call_user_func($route->getAction()))->toBe('test success');
});

it('will return null if there is not route that match a simple url', function () {
    $route = $this->router->findRouteThatMatches('GET', '/');

    expect($route)->toBeNull();
});