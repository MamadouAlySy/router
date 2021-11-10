# Router

A simple php router

## Requirements

- PHP version: `>=8.0`

### Initialization

```php
<?php

require_once './vendor/autoload.php';

$router = new \MamadouAlySy\Router(
    new \MamadouAlySy\RouteCollection()
);

```

### Routes Registration

```php

$router->get('/', function () {/**/});
$router->post('/', function () {/**/});
$router->put('/', function () {/**/});
$router->delete('/', function () {/**/});
$router->any('/', function () {/**/});

```

### Matching Routes

```php

$route = $router->match('GET', '/'); // => returns a route if match or null if not match

$route->getName(); // => returns the route name
$route->getCallable(); // => returns the route action
$route->getParameters(); // => returns the route matched parameters

```

### Dynamic Routes

```php

$router->get('/user/:id', function () {/**/})->with('id', '[0-9]+');
$router->get('/:action/:name', function () {/**/});

```

### Generating route url

```php

$router->get('/edit/:id', function () {/**/}, 'app.edit');

$router->generateUri('app.edit', [id => 2]); // => returns /edit/2

```
