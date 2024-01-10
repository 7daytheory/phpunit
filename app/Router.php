<?php 

//Strict type checking
declare(strict_types=1);

//Defines the namespace for the class
namespace App;

//Import Exceptions class (currently not made)
use App\Exceptions\RouterNotFoundException;

class Router {

    //Private property - array - store information about routes
    private array $routes;

    /**
     * Register a new route with its associated action.
     *
     * @param string $requestMethod The HTTP request method ex: GET/POST
     * @param string $route         The URI route to be registered.
     * @param callable|array $action The action associated with the route (callback function or controller/method array).
     *
     * @return $this
     */
    
    public function register(string $requestMethod, string $route, callable|array $action) 
    {
        // Store the provided action for the given route and request method.
        $this->routes[$requestMethod][$route] = $action;

        // Allow method chaining by returning the current instance of the class.
        return $this;
    }

}