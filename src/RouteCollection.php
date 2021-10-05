<?php

namespace MamadouAlySy;

class RouteCollection
{
    private array $collection = [];

    private array $supportedMethod = ['get', 'post', 'put', 'delete'];

    protected array $regexPattern = [
        '#{int:(\w+)}#' => '([0-9]+)',
        '#{string:(\w+)}#' => '([a-zA-Z]+)',
        '#{\*:(\w+)}#' => '(.+)',
    ];

    public function __construct()
    {}


    /**
     * Adds new route to the routing table
     *
     * @param array $methods
     * @param Route $route
     */
    public function add(array $methods, Route $route): void
    {
        foreach ($methods as $method)
            $this->collection[strtolower($method)][] = $route;
    }

    /**
     * @return array all routes
     */
    public function all(): array
    {
        return $this->collection;
    }

    /**
     * Returns all routes for the given method
     * @param string $method
     * @return Route[]
     */
    public function getRoutes(string $method): array
    {
        $method = strtolower($method);
        return $this->collection[$method];
    }

    /**
     * @param string $path
     * @return string the regular expression pattern corresponding to the given path
     */
    protected function getRegexPath(string $path): string
    {
        foreach ($this->regexPattern as $key => $regex) {
            $path = preg_replace($key, $regex, $path);
        }

        return '#^'.$path.'$#';
    }

    /**
     * Finds a route that matches the given method and url
     *
     * @param string $method
     * @param string $url
     * @return Route|null
     */
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

    public function findRouteWithName(string $name): ?Route
    {
        foreach ($this->supportedMethod as $method) {
            foreach ($this->getRoutes($method) as $route) {
                if ($route->getName() === $name) {
                    return $route;
                }
            }
        }

        return null;
    }

    public function generateUrlForRouteNamed(string $name, array $parameters = []): ?string
    {
        $route = $this->findRouteWithName($name);

        if (!$route)
            return null;

        $path = $route->getPath();


        foreach ($parameters as $key => $value) {
            $path = preg_replace("#{([a-zA-Z]+):$key}#", $value, $path);
        }

        return $path;
    }
}