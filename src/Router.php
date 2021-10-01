<?php

namespace MamadouAlySy;

class Router
{
    protected array $routes = [];

    public function add(Route $route): void
    {
        $method = $route->getMethod();
        $this->routes[$method][] = $route;
    }

    public function getRoutes(string $method = 'get'): array
    {
        $method = strtolower($method);
        return $this->routes[$method] ?? [];
    }

    public function findRouteThatMatches(string $method, string $url): ?Route
    {
        $routes = $this->getRoutes($method);
        foreach ($routes as $route) {
            $path = $route->getPath();
            if (preg_match("#^{$path}$#", $url, $matches)) {
                $route->setParameters($matches);
                return $route;
            }
        }
        return null;
    }
}