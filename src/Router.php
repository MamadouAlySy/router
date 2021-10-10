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

    public function getRouteCollection()
    {
        return new $this->routeCollection;
    }

    protected function add(string $methods, string $path, Closure | array $callable, ?string $name = null): void
    {
        foreach (explode('|', $methods) as $method) {
            $this->routeCollection->add($method, new Route($path, $callable, $name));
        }
    }

    public function get(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('get', $path, $callable, $name);
    }

    public function post(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('post', $path, $callable, $name);
    }

    public function put(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('put', $path, $callable, $name);
    }

    public function delete(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('delete', $path, $callable, $name);
    }

    public function any(string $path, Closure | array $callable, ?string $name = null): void
    {
        $this->add('get|post|put|delete', $path, $callable, $name);
    }

    public function generateUri(string $name, array $parameters = [])
    {
        $route = $this->routeCollection->get($name);
        return $route->generateUri($parameters);
    }
}
