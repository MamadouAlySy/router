# Router
A simple php router

# Requirements
- PHP version: `>=8.0`

### Initialisation

```php
<?php

require_once './vendor/autoload.php';

$router = new \MamadouAlySy\Router(); 

// or

$routeCollection = new \MamadouAlySy\RouteCollectionFactory(
    [
       'home' => [
           'path' => '/',
           'action' => 'HomeController::index',
           'methods' => ['GET']
       ]
    ];
);

$router = new \MamadouAlySy\Router($routeCollection);

```

### Routes Registration

```php

$router->get('/', function () {/**/});
$router->post('/', function () {/**/});
$router->put('/', function () {/**/});
$router->delete('/', function () {/**/});
$router->any('/', function () {/**/});

```

### Generating route url

```php

$router->get('/edit/{int:id}', function () {/**/}, 'app.edit'); or null if not match

$router->generate('app.edit', [id => 2]) // => returns /edit/2

```

### Matching Routes

```php

$route = $router->match('GET', '/') // => returns a route if match or null if not match

$route->getName() // => returns the route name
$route->getAction() // => returns the route action
$route->getParameters() // => returns the route matched parameters

```

### Dynamic Routes

```php

'{int:id}'         => 'id => ([0-9]+)'
'{string:name}'    => 'name => ([a-zA-Z]+)'
'{*:name}'         => 'name => (.+)'

```