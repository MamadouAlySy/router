<?php

use MamadouAlySy\Route;
use MamadouAlySy\RouteCollection;

beforeEach(function () {
    $this->routeCollection = new RouteCollection();
});

it('can add routes', function () {
    $this->routeCollection->add(['get', 'post'], new Route('/', function () {}));

    expect($this->routeCollection->getRoutes('GET'))->toHaveCount(1);

    expect($this->routeCollection->getRoutes('POST'))->toHaveCount(1);
});

it('can find route that match a simple url', function () {
    $this->routeCollection->add(['get'], new Route('/', function () { return 'test success'; }));

    $route = $this->routeCollection->findRouteThatMatches('GET', '/');

    expect($route)->toBeInstanceOf(Route::class);

    $content = call_user_func_array($route->getAction(), $route->getParameters());

    expect($content)->toBe('test success');
});

it('can find route that match a complex url', function () {
    $this->routeCollection->add(['get'], new Route('/user/{int:id}', function ($id) {
            return 'user ' . $id;
        })
    );

    $route = $this->routeCollection->findRouteThatMatches('GET', '/user/12');

    expect($route)->toBeInstanceOf(Route::class);

    $content = call_user_func_array($route->getAction(), $route->getParameters());

    expect($content)->toBe('user 12');


});

it('will return null if there is not route that match a simple url', function () {
    $this->routeCollection->add(['get'], new Route( '/user/{?int:id}', function () {}));

    $route = $this->routeCollection->findRouteThatMatches('GET', '/user/a');

    expect($route)->toBeNull();
});