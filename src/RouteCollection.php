<?php

namespace MamadouAlySy;

class RouteCollection
{
    private array $collection = [];

    protected array $regexPattern = [
        '#{int:(\w+)}#' => '([0-9]+)',
        '#{string:(\w+)}#' => '([a-zA-Z]+)',
        '#{\*:(\w+)}#' => '(.+)',
    ];

    public function __construct()
    {}


    public function add(array $methods, Route $route): void
    {
        foreach ($methods as $method)
            $this->collection[strtolower($method)][] = $route;
    }

    public function all(): array
    {
        return $this->collection;
    }

    public function getRoutes(string $method)
    {
        $method = strtolower($method);
        return $this->collection[$method];
    }

    protected function getRegexPath(string $path): string
    {
        foreach ($this->regexPattern as $key => $regex) {
            $path = preg_replace($key, $regex, $path);
        }

        return '#^'.$path.'$#';
    }

    public function findRouteThatMatches(string $method, string $url): ?Route
    {
        foreach ($this->getRoutes($method) as $route) {

            $regexPath = $this->getRegexPath($route->getPath());

            if (preg_match($regexPath, $url, $matches)) {

                unset($matches[0]);
                $route->setParameters($matches);

                return $route;
            }
        }

        return null;
    }
}