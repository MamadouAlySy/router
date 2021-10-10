<?php

declare(strict_types=1);

namespace MamadouAlySy;

use Closure;

class Router
{
    protected RouteCollection $routeCollection;

    public function __construct(?RouteCollection $routeCollection = null)
    {
        $this->routeCollection = $routeCollection ?? new RouteCollection();
    }

    /**
     * @return RouteCollection the router routes collection
     */
    public function getRouteCollection(): RouteCollection
    {
        return $this->routeCollection;
    }

    /** 
     * Adds new route to the routes collection
     * 
     * @param string $methods
     * @param string $path
     * @param Closure|array $callable
     * @param string|null $name
     */
    protected function add(string $methods, string $path, Closure | array $callable, ?string $name = null): void
    {
        foreach (explode('|', $methods) as $method) {
            $this->routeCollection->add($method, new Route($path, $callable, $name));
        }
    }

    /**
     * Adds a get to the routes collection
     */
    public function get(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('get', $path, $callable, $name);
    }

    /**
     * Adds a post to the routes collection
     */
    public function post(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('post', $path, $callable, $name);
    }

    /**
     * Adds a put to the routes collection
     */
    public function put(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('put', $path, $callable, $name);
    }

    /**
     * Adds a delete to the routes collection
     */
    public function delete(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('delete', $path, $callable, $name);
    }

    /**
     * Adds a route to the routes collection that support all methods (get, post, put, delete)
     */
    public function any(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('get|post|put|delete', $path, $callable, $name);
    }

    /**
     * Generate route uri for the given route name
     *
     * @param string $name
     * @param array $parameters
     * @return string the generated uri
     */
    public function generateUri(string $name, array $parameters = []): string
    {
        $route = $this->routeCollection->get($name);
        return $route->generateUri($parameters);
    }
}
