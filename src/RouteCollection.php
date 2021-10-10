<?php

declare(strict_types=1);

namespace MamadouAlySy;

use MamadouAlySy\Exceptions\RouteNotFoundException;

class RouteCollection
{
    protected array $routes;
    protected array $namedRoutes;

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    public function add(string $method, Route $route): Route
    {
        $method = strtolower($method);
        $this->routes[$method][] = $route;
        if ($route->getName() !== null) {
            $this->namedRoutes[$route->getName()] = $route;
        }

        return $route;
    }

    public function getRoutes(?string $method = null): array
    {
        if ($method) {
            return $this->routes[$method];
        }
        return $this->routes;
    }

    public function get(string $name): Route
    {
        if (isset($this->namedRoutes[$name])) {
            return $this->namedRoutes[$name];
        }
        throw new RouteNotFoundException("No route found with the name \"$name\"");
    }
}
