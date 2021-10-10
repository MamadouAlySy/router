<?php

use MamadouAlySy\Exceptions\RouteCallException;
use MamadouAlySy\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testCanMatchASimpleRoute()
    {
        $route = new Route('/home', function () {});
        $this->assertTrue($route->match('/home'));
    }

    public function testCanMatchADynamicRoute()
    {
        $route = new Route('/post/:id-:slug', function () {});
        $this->assertTrue($route->match('/post/5-long-board'));
    }

    public function testCanMatchADynamicRouteAndGetParametersByUsingWithMethod()
    {
        $route = (new Route('/post/:id-:slug', function () {}))->with('id', '[0-9]+');
        $route->match('/post/5-long-board');
        $this->assertEquals(['5', 'long-board'], $route->getParameters());
    }

    public function testCanMatchADynamicRouteAndGetParameters2()
    {
        $route = new Route('/post/:slug-:id', function () {});
        $route->match('/post/long-board-5');
        $this->assertEquals(['long-board', '5'], $route->getParameters());
    }

    public function testWillReturnFalseIfNotMatches()
    {
        $route = new Route('/', function () {});
        $this->assertFalse($route->match('/post'));
    }

    public function testCanCallARoute()
    {
        $route = new Route('/', function () { return 'hello'; });
        $this->assertSame($route->call(), 'hello');
    }

    public function testWillReturnAnExceptionIfControllerNotExistWhenCallingARoute()
    {
        $this->expectException(RouteCallException::class);
        $route = new Route('/', ['App\Controller\HomeController', 'index']);
        $route->call();
    }
}
