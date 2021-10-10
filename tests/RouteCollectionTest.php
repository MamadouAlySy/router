<?php

use MamadouAlySy\Exceptions\RouteNotFoundException;
use MamadouAlySy\Route;
use MamadouAlySy\RouteCollection;
use PHPUnit\Framework\TestCase;

class RouteCollectionTest extends TestCase
{
    protected RouteCollection $routeCollection;

    protected function setUp(): void
    {
        parent::setUp();
        $this->routeCollection = new RouteCollection();
    }
    
    public function testCanAddNewRoute()
    {
        $this->routeCollection->add('get', new Route('/', function () {}));

        $this->assertCount(
            expectedCount: 1,
            haystack: $this->routeCollection->getRoutes('get')
        );
    }

    public function testCanGetRouteByName()
    {
        $this->routeCollection->add('get', new Route('/', function () {}, 'test'));
        $route = $this->routeCollection->get('test');

        $this->assertSame(
            expected: $route->getName(),
            actual: 'test'
        );
    }

    public function testWillThrowAnExceptionIfNoRouteFound()
    {
        $this->expectException(exception: RouteNotFoundException::class);
        $this->routeCollection->get('test');
    }
}
