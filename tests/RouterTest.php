<?php

namespace MamadouAlySy\Tests;

use MamadouAlySy\Route;
use MamadouAlySy\Router;
use PHPUnit\Framework\TestCase;
use MamadouAlySy\RouteCollection;
use MamadouAlySy\Exceptions\RouteNotFoundException;

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
            expected:RouteCollection::class,
            actual:$this->router->getRouteCollection()
        );
    }

    public function testCanGenerateRoutUri()
    {
        $this->router->get('/user/:id', [], 'user.show');

        $this->assertEquals(
            expected:'/user/5',
            actual:$this->router->generateUri('user.show', ['id' => 5])
        );
    }

    public function testCanRunTheRouter()
    {
        $this->router->get('/', function () {
            return 'hello';
        });

        $this->assertInstanceOf(
            expected:Route::class,
            actual:$this->router->run('get', '/')
        );
    }

    public function willThowsExceptionIfNoRouteFound()
    {
        $this->expectException(RouteNotFoundException::class);
        $this->router->run('get', '/');
    }
}
