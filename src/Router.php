<?php

namespace MamadouAlySy;

use Closure;

class Router
{
    protected RouteCollection $routeCollection;

    /**
     * @param RouteCollection|null $routeCollection
     */
    public function __construct(?RouteCollection $routeCollection = null)
    {
        $this->routeCollection = $routeCollection ?? new RouteCollection();
    }

    /**
     * Register a route as get method
     */
    public function get(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['get'], new Route($path, $action, $name));
    }

    /**
     * Register a route as post method
     */
    public function post(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['post'], new Route($path, $action, $name));
    }

    /**
     * Register a route as put method
     */
    public function put(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['put'], new Route($path, $action, $name));
    }

    /**
     * Register a route as delete method
     */
    public function delete(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['delete'], new Route($path, $action, $name));
    }

    /**
     * Register a route for all method
     */
    public function any(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['get', 'post', 'put', 'delete'], new Route($path, $action, $name));
    }

    /**
     * Match all routes and find a route that matches the given method and url
     *
     * @param string $method
     * @param string $url
     * @return Route|null
     */
    public function match(string $method, string $url): ?Route
    {
        return $this->routeCollection->findRouteThatMatches($method, $url);
    }

    /**
     * Generate url for a route with the given name
     *
     * @param string $name the name of the route
     * @param array $parameters
     * @return string|null
     */
    public function generate(string $name, array $parameters = []): ?string
    {
        return $this->routeCollection->generateUrlForRouteNamed($name, $parameters);
    }
}