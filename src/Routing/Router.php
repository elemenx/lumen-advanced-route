<?php

namespace BranchZero\AdvancedRoute\Routing;

use Illuminate\Support\Arr;

class Router extends \Laravel\Lumen\Routing\Router
{
    protected $namespaceStack = [];
    protected $prefixesStack = [];
    protected $middlewareStack = [];

    /**
     * Register a set of routes with a set of shared attributes.
     *
     * @param  array  $attributes
     * @param  \Closure  $callback
     * @return void
     */
    public function group(array $attributes, \Closure $callback)
    {
        // merge middleware
        if (!empty($attributes['middleware'])) {
            // prepare the last middleware
            $lastMiddleware = end($this->middlewareStack);
            $lastMiddleware = is_array($lastMiddleware) ? $lastMiddleware : [];
            // prepare current middleware
            $middleware = is_array($attributes['middleware']) ? $attributes['middleware'] : [$attributes['middleware']];
            // merge middleware
            $attributes['middleware'] = array_merge($lastMiddleware, $middleware);
        } else {
            $attributes['middleware'] = end($this->middlewareStack) ? : null;
        }
        // merge prefixes
        if (!empty($attributes['prefix'])) {
            if (count($this->prefixesStack)) {
                $attributes['prefix'] = end($this->prefixesStack) . '/' . trim($attributes['prefix'], '/');
            } else {
                $attributes['prefix'] = trim($attributes['prefix'], '/');
            }
        } else {
            $attributes['prefix'] = end($this->prefixesStack) ? : null;
        }
        
        if (config('advanced_route.namespace', 'nested') === 'nested') {
            // merge namespace
            if (!empty($attributes['namespace'])) {
                if (count($this->namespaceStack)) {
                    $attributes['namespace'] = end($this->namespaceStack) . '\\' . trim($attributes['namespace'], '\\');
                } else {
                    $attributes['namespace'] = trim($attributes['namespace'], '\\');
                }
            } else {
                $attributes['namespace'] = end($this->namespaceStack) ?: null;
            }
        }

        // merge attributes
        $this->groupAttributes = isset($this->groupAttributes) ? array_merge($this->groupAttributes, $attributes) : $attributes;

        // save current middleware for nested routes
        $this->middlewareStack[] = !empty($attributes['middleware']) ? $attributes['middleware'] :
            !empty($this->groupAttributes['middleware']) ? $this->groupAttributes['middleware'] : [];
        // save a current prefix for nested routes
        $this->prefixesStack[] = !empty($attributes['prefix']) ? trim($attributes['prefix'], '/') :
            !empty($this->groupAttributes['prefix']) ? $this->groupAttributes['prefix'] : '';
        // save a current namespace for nested routes
        $this->namespaceStack[] = !empty($attributes['namespace']) ? trim($attributes['namespace'], '\\') :
            !empty($this->groupAttributes['namespace']) ? $this->groupAttributes['namespace'] : '';

        // var_dump($this->groupAttributes); // uncomment this line to debug routing attributes
        call_user_func($callback, $this);

        // remove the last prefix and last middleware since we got the end of this group branch
        array_pop($this->middlewareStack);
        array_pop($this->prefixesStack);
        array_pop($this->namespaceStack);
    }

    /**
     * Register a route with the application with all methods:
     * GET, POST, PUT, PATCH, DELETE and OPTIONS
     *
     * @param  string  $uri
     * @param  mixed  $action
     * @return $this
     */
    public function any($uri, $action)
    {
        $methods = [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'OPTIONS',
        ];

        return $this->match($methods, $uri, $action);
    }

    /**
     * Register a route with the application with exactly defined methods.
     *
     * @param  array $methods
     * @param  string $uri
     * @param  mixed $action
     * @return $this
     */
    public function match($methods, $uri, $action)
    {
        foreach ($methods as $method) {
            $this->addRoute($method, $uri, $action);
        }

        return $this;
    }

    /**
     * Register an array of resource controllers.
     *
     * @param  array  $resources
     * @return void
     */
    public function resources(array $resources)
    {
        foreach ($resources as $name => $controller) {
            $this->resource($name, $controller);
        }
    }

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\PendingResourceRegistration
     */
    public function resource($name, $controller, array $options = [])
    {
        if ($this->container && $this->container->bound(ResourceRegistrar::class)) {
            $registrar = $this->container->make(ResourceRegistrar::class);
        } else {
            $registrar = new ResourceRegistrar($this);
        }

        return new PendingResourceRegistration(
            $registrar, $name, $controller, $options
        );
    }

    /**
     * Set the unmapped global resource parameters to singular.
     *
     * @param  bool  $singular
     * @return void
     */
    public function singularResourceParameters($singular = true)
    {
        ResourceRegistrar::singularParameters($singular);
    }

    /**
     * Set the global resource parameter mapping.
     *
     * @param  array  $parameters
     * @return void
     */
    public function resourceParameters(array $parameters = [])
    {
        ResourceRegistrar::setParameters($parameters);
    }
}
