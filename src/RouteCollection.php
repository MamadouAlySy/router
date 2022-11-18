<?php

declare (strict_types = 1);

namespace MamadouAlySy;

use MamadouAlySy\Exceptions\RouteNotFoundException;

class RouteCollection
{
    protected array $routes;
    protected array $namedRoutes;

    /**
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * Adds new route to the collection
     */
    public function add(string $method, Route $route): Route
    {
        $method = strtolower($method);
        $this->routes[$method][] = $route;

        if ($route->getName() !== null) {
            $this->namedRoutes[$route->getName()] = $route;
        }

        return $route;
    }

    /**
     * Return all route for the given method.
     * Note: if $method parameter is not specified it will return all routes for all methods
     *
     * @param string|null $method
     * @return array<Route>
     */
    public function getRoutes(?string $method = null): array
    {

        if ($method) {
            return $this->routes[$method];
        }

        return $this->routes;
    }

    /**
     * Returns a route with the given name
     *
     * @throws RouteNotFoundException
     */
    public function get(string $name): Route
    {

        if (isset($this->namedRoutes[$name])) {
            return $this->namedRoutes[$name];
        }

        throw new RouteNotFoundException("No route found with the name \"$name\"");
    }

}
