# Note

inspired by fremail/lumen-nested-route-groups, adding support for lumen resource route.

# Changelog
 - **v.0.1.1** Remove Useless Code.
 - **v.0.1.0** Add Support For Lumen 5.5 && Resource.


## How to install (steps)

### 1. Install using Composer

```
composer require "branchzero/lumen-advanced-route:~0.1"
```

### 2. Required changes in bootstrap/app.php
Change initialization of Lumen Application class to initialization of Lumen Nested Route Groups Application class in bootstrap/app.php.

Before:

```
$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);
```

After:

```
$app = new BranchZero\AdvancedRoute\Application(
    realpath(__DIR__.'/../')
);
```

## Any() and Match() and resource() methods
Do you like `any()` and `match()` methods on Laravel? I love them! That's why I added supporting them on Lumen.
The syntax is the same as for [Laravel](https://laravel.com/docs/master/routing#basic-routing):
```
$app->match($methods, $uri, $action);
```
Where 
_$methods_ - an array of methods. Example: `['get', 'post', 'delete']`. _$uri_ and _$action_ are the same as on other methods
```
$app->any($uri, $action);
```
Here are _$uri_ and _$method_ are the same as on other methods like `$app->get(...)` etc.

## Example of using this lib
This is an example of routes/web.php

```
$app->group(['middleware' => 'auth'], function () use ($app) {

    $app->get('test', function () {
        echo "Hello world!";
    });

    $app->resource('user', 'UserController', ['only' => ['show', 'store', 'destroy']]);

    /**
     * only admins
     */
    $app->group(['middleware' => 'admin'], function () use ($app) {

        $app->group(['prefix' => 'admin'], function () use ($app) {
            $app->get('/', 'AdminController@index');
        });

    });
    
    /**
     * $app->any and $app->match available from v1.1.0
     */
    $app->any('/', function () use ($app) {
        echo "Hey! I don't care it's POST, GET, PATCH or another method. I'll answer on any of them :)";
    });
    
    $app->match(['PATCH', 'PUT', 'DELETE'], '/old/', function () use ($app) {
        echo "This is an old part of our site without supporting REST. Please use only GET and POST here.";
    });

});
```

