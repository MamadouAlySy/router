<?php

namespace MamadouAlySy\Tests;

use MamadouAlySy\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testCanMatchASimpleRoute()
    {
        $route = new Route('/home', function () {});
        $this->assertTrue(condition:$route->matchUrl('/home'));
    }

    public function testCanMatchADynamicRoute()
    {
        $route = (new Route('/post/:id-:slug', function () {}))
            ->with('id', '[0-9]+')
            ->with('slug', '[a-z\-]+');
        $this->assertTrue(condition:$route->matchUrl('/post/5-long-board'));
    }

    public function testCanMatchADynamicRouteAndGetParametersByUsingWithMethod()
    {
        $route = (new Route('/post/:id-:slug', function () {}))->with('id', '[0-9]+');
        $route->matchUrl('/post/5-long-board');
        $this->assertEquals(
            expected:['id' => '5', 'slug' => 'long-board'],
            actual:$route->getParameters()
        );
    }

    public function testCanMatchADynamicRouteAndGetParameters2()
    {
        $route = (new Route('/post/:slug-:id', function () {}))->with('id', '[0-9]+');
        $route->matchUrl('/post/long-board-5');
        $this->assertEquals(
            expected:['slug' => 'long-board', 'id' => '5'],
            actual:$route->getParameters()
        );
    }

    public function testWillReturnFalseIfNotMatches()
    {
        $route = new Route('/', function () {});
        $this->assertFalse(condition:$route->matchUrl('/post'));
    }
}
