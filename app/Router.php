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

    /**
     * Register a new route with its associated action for the HTTP GET method.
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

 /**
 * Get all registered routes.
 *
 * @return array
 */
public function routes(): array {
    return $this->routes;
}

    /**
     * Resolve a route based on the provided request URI and method.
     *
     * @param string $requestURI   The full request URI, including the query string.
     * @param string $requestMethod The HTTP request method ex Get/Post
    *
    * @return mixed The result of the resolved action.
    *
    * @throws RouteNotFoundException When the requested route is not found.
    */
    public function resolve(string $requestURI, string $requestMethod) 
    {
        // Extract the route from the request URI
        $route = explode('?', $requestURI)[0];
        
        // Retrieve the action associated with the route and request method, or null if not found.
        $action = $this->routes[$requestMethod][$route] ?? null;

        // Check if the action is not found, and throw an exception if so.
        if (! $action) 
        {
            throw new RouteNotFoundException();
        }

        // If the action is a callable function or closure , execute it
        if (is_callable($action))
        {
            return call_user_func($action);
        }

        // If the action is an array representing a class and method
        if (is_array($action))
        {
            [$class, $method] = $action;

            // Check if the class exists
            if (class_exists($class))
            {
                // Instantiate the class.
                $instance = new $class();

                // Check if the method exists
                if (method_exists($instance, $method))
                {
                    // Call the method on the instantiated class
                    return call_user_func_array([$instance, $method], []);
                }
            }
        }
    }
}