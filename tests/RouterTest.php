<?php

use MamadouAlySy\Route;
use MamadouAlySy\RouteCollection;
use MamadouAlySy\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected Router $router;

    protected function setUp(): void
    {
        parent::setUp();
        $routeCollection = new RouteCollection();
        $this->router = new Router($routeCollection);
    }
    

    public function testWillReturnTheRouteCollection()
    {
        $this->assertInstanceOf(
            expected: RouteCollection::class,
            actual: $this->router->getRouteCollection()
        );
    }

    public function testCanGenerateRoutUri()
    {
        $this->router->get('/user/:id', [], 'user.show');

        $this->assertEquals(
            expected: '/user/5',
            actual: $this->router->generateUri('user.show', ['id' => 5])
        );
    }
}
