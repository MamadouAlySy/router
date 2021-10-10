<?php

use MamadouAlySy\Exceptions\RouteCallException;
use MamadouAlySy\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testCanMatchASimpleRoute()
    {
        $route = new Route('/home', function () {});
        $this->assertTrue(condition: $route->match('/home'));
    }

    public function testCanMatchADynamicRoute()
    {
        $route = new Route('/post/:id-:slug', function () {});
        $this->assertTrue(condition: $route->match('/post/5-long-board'));
    }

    public function testCanMatchADynamicRouteAndGetParametersByUsingWithMethod()
    {
        $route = (new Route('/post/:id-:slug', function () {}))->with('id', '[0-9]+');
        $route->match('/post/5-long-board');
        $this->assertEquals(
            expected: ['5', 'long-board'], 
            actual: $route->getParameters()
        );
    }

    public function testCanMatchADynamicRouteAndGetParameters2()
    {
        $route = new Route('/post/:slug-:id', function () {});
        $route->match('/post/long-board-5');
        $this->assertEquals(
            expected: ['long-board', '5'],
            actual: $route->getParameters()
        );
    }

    public function testWillReturnFalseIfNotMatches()
    {
        $route = new Route('/', function () {});
        $this->assertFalse(condition: $route->match('/post'));
    }

    public function testCanCallARoute()
    {
        $route = new Route('/', function () { return 'hello'; });
        $this->assertSame(
            expected: $route->call(),
            actual: 'hello'
        );
    }

    public function testWillReturnAnExceptionIfControllerNotExistWhenCallingARoute()
    {
        $this->expectException(exception: RouteCallException::class);
        $route = new Route('/', ['App\Controller\HomeController', 'index']);
        $route->call();
    }
}
