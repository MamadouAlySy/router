<?php

namespace MamadouAlySy;

class Router
{
    protected array $routes = [];
    protected array $regexPattern = [
        '#{int:(\w+)}#' => '([0-9]+)',
        '#{string:(\w+)}#' => '([a-zA-Z]+)',
        '#{\*:(\w+)}#' => '(.+)',
    ];

    public function add(Route $route): void
    {
        $this->routes[$route->getMethod()][] = $route;
    }

    public function getRoutes(string $method = 'get'): array
    {
        return $this->routes[strtolower($method)] ?? [];
    }

    public function findRouteThatMatches(string $method, string $url): ?Route
    {
        $routes = $this->getRoutes($method);

        foreach ($routes as $route) {

            $regexPath = $this->getRegexPath($route->getPath());

            if (preg_match($regexPath, $url, $matches)) {

                $params = [];
                unset($matches[0]);

                foreach ($matches as $key => $values) {
                    $params[] = trim($values, '/');
                }

                $route->setParameters($params);

                return $route;
            }

        }
        return null;
    }

    protected function getRegexPath(string $path): string
    {
        foreach ($this->regexPattern as $key => $regex) {
            $path = preg_replace($key, $regex, $path);
        }

        return '#^'.$path.'$#';
    }
}