<?php

namespace MamadouAlySy;

class RouteCollectionFactory
{
    public static function create(array $routes = []): RouteCollection
    {
        $routeCollection = new RouteCollection();

        foreach ($routes as $name => $parameters) {
            $routeCollection->add(
                $parameters['methods'] ?? ['GET'],
                new Route($parameters['path'], $parameters['action'], $name)
            );
        }

        return $routeCollection;
    }
}
