# Note

this is a modification based in fremail/lumen-nested-route-groups, adding support for Lumen 5.5 && resource route.

# Changelog
**v.0.1.0** Add Support For Lumen 5.5 && Resource.


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

### After these simple steps you can use nested route groups in your application!


## Additional namespaces configuration
By default this lib uses nested namespace ([Laravel style](https://laravel.com/docs/5.2/routing#route-group-namespaces)), but you can determine to use full namespaces instead ([Lumen style](https://lumen.laravel.com/docs/5.2/routing#route-group-namespaces)).

**Steps for using full namespaces:**

1. Create `config` directory if you don't have one in the project root.

2. Copy `advanced_route.php` from `vendor/branchzero/lumen-advanced-route/config` folder to the created `config` dir in the root.

3. Open the `config/advanced_route.php` file and set 'namespace' value to 'full'.

4. Add this line to your bootstrap/app.php: `$app->configure('advanced_route');`


## Any() and Match() methods
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

    $app->group(['prefix' => 'user'], function () use ($app) {
        $app->get('{id}', 'UserController@show');
        $app->post('/', 'UserController@store');
        $app->delete('{id}', 'UserController@destroy');
    });

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

