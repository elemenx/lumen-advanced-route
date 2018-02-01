<?php

namespace BranchZero\AdvancedRoute\Routing;

class Router extends \Laravel\Lumen\Routing\Router
{
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
        if ($this->app->bound(ResourceRegistrar::class)) {
            $registrar = $this->app->make(ResourceRegistrar::class);
        } else {
            $registrar = new ResourceRegistrar($this);
        }

        return new PendingResourceRegistration(
            $registrar,
            $name,
            $controller,
            $options
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
