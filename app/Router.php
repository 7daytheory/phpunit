<?php

declare(strict_types=1);

//Defines the namespace for the class
namespace App;

use App\Exceptions\RouteNotFoundException;

class Router 
{
    private array $routes = [];

    /**
     *
     * @param string $requestMethod The HTTP request method ex: GET/POST
     * @param string $route         The URI route to be registered.
     * @param callable|array $action The action associated with the route (callback function or controller/method array).
     *
     * @return $this
     */
    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        // Store the provided action for the given route and request method.
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    /**
     *
     * @param string $route         The URI route to be registered.
     * @param callable|array $action The action associated with the route (callback function or controller/method array).
     *
     * @return $this
     */
    public function get(string $route, callable|array $action): self 
    {
        // Calls register method, using 'get' as the request method.
        return $this->register('get', $route, $action);
    }

    /**
     * Register a new route with its associated action for the HTTP POST method.
     *
     * @param string $route         The URI route to be registered.
     * @param callable|array $action The action associated with the route (callback function or controller/method array).
     *
     * @return $this
     */
    public function post(string $route, callable|array $action): self 
    {
        // Calls register method, using 'post' as the request method.
        return $this->register('post', $route, $action);
    }

    public function routes(): array 
    {
        return $this->routes;
    }
    
    public function resolve(string $requestUri, string $requestMethod) 
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;
    
        if (! $action) 
        {
            throw new RouteNotFoundException("Route not found for {$requestMethod} {$route}");
        }
      
        if (is_callable($action))
        {
            return call_user_func($action);
        }   
        
        [$class, $method] = $action;
    
        if (class_exists($class))
        {
            $class = new $class();

            if (method_exists($class, $method))
            {
                return call_user_func_array([$class, $method], []);
            }
        }
        throw new RouteNotFoundException();
    }
}