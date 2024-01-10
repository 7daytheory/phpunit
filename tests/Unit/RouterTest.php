<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    // Declare a private property $router of type Router
    private Router $router;

    // This method is called before each test to set up the initial state
    protected function setUp(): void 
    {
        // Call the parent class's setUp method to perform any parent class setup
        parent::setUp();

        // Create a new instance of the Router class and assign to router property
        $this->router = new Router();
    }

    public function test_if_it_registers_a_route(): void
    {   
        // Register a route for the 'get' HTTP method at the path '/users', pointing to the ['Users', 'index'] controller action
        $this->router->register('get', '/users', ['Users', 'index']);
    
        // Define the expected result after registering the route
        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];
    
        // Assert that the routes returned by the router match the expected result
        $this->assertEquals($expected, $this->router->routes());
    }
    
    public function test_it_registers_a_get_route(): void 
    {
        // Register a route for the 'get' HTTP method
        $this->router->get('/users', ['Users', 'index']);
    
        // Define the expected result after registering the route
        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];
    
        // Assert that the routes returned by the router match the expected result
        $this->assertEquals($expected, $this->router->routes());
    }
    
    public function test_it_registers_a_post_route(): void 
    {
        // Register a route for the 'post' HTTP method
        $this->router->post('/users', ['Users', 'index']);
    
        // Define the expected result after registering the route
        $expected = [
            'post' => [
                '/users' => ['Users', 'index'],
            ],
        ];
    
        // Assert that the routes returned by the router match the expected result
        $this->assertEquals($expected, $this->router->routes());
    }
    
    public function test_no_routes_when_creates()
    {
        //Create a new instance
        //$router = new Router(); //Would still work without this but it's specificially testing new router scenarion with no routes

        // Assert that the router has no routes when it is created
        $this->assertEmpty((new Router())->routes());
    }

    /**
     * @test
     * @dataProvider routeNotFoundCasesDataProvider
     */
    public function test_throws_not_found_exception(string $requestUri, string $requestMethod): void
    {
        $users = new class() {
            public function delete(): bool
            {
                return true;
            }
        };

        $this->router->get('/users', [$users::class, 'store']);
        $this->router->post('/users', ['Users', 'store']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    //Passes data to the above function
    public function routeNotFoundCasesDataProvider(): array 
    {
        return [
            ['/users', 'putt'],
            ['/invoices', 'post'],
            ['/users', 'get'],
            ['/users', 'post'],
        ];
    }
}    