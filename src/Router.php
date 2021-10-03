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

    public function get(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['get'], new Route($path, $action, $name));
    }

    public function post(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['post'], new Route($path, $action, $name));
    }

    public function put(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['put'], new Route($path, $action, $name));
    }

    public function delete(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['delete'], new Route($path, $action, $name));
    }

        public function any(string $path, Closure|array|string $action, ?string $name = null): void
    {
        $this->routeCollection->add(['get', 'post', 'put', 'delete'], new Route($path, $action, $name));
    }

    public function match(string $method, string $path): ?Route
    {
        return $this->routeCollection->findRouteThatMatches($method, $path);
    }
}