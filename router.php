<?php
namespace MJDawson\Router;

/**
 * Router class to handle HTTP requests and route them to the appropriate callbacks.
 *
 * This class allows you to define routes for different HTTP methods and URIs,
 * and it will call the corresponding callback function when a request matches a route.
 */
class Router {
    private $routes = [];

    /**
     * Add a route to the router.
     *
     * @param string $method The HTTP method (GET, POST, etc.)
     * @param string $route The URI route to match
     * @param callable $callback The callback function to execute when the route matches
     */
    public function addRoute($method, $route, $callback) {
        // Remove trailing slash from the route when adding
        $route = rtrim($route, '/');
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => $route,
            'callback' => $callback
        ];
    }

    /**
     * Get the list of defined routes.
     *
     * @return array An array of routes
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Check if a route exists for the given method and route.
     *
     * @param string $method The HTTP method (GET, POST, etc.)
     * @param string $route The URI route to check
     * @return bool True if the route exists, false otherwise
     */
    public function routeExists($method, $route) {
        // Remove trailing slash from the route for uniform matching
        $route = rtrim($route, '/');
        foreach ($this->routes as $r) {
            if ($r['method'] === strtoupper($method) && $r['route'] === $route) {
                return true;
            }
        }
        return false;
    }

    /**
     * Handle the incoming request and route it to the appropriate callback.
     *
     * @param string[] $page The requested page URI
     */
    public function handleRequest($page) {
        // Get the current URI and method
        $method = $_SERVER['REQUEST_METHOD'];

        // Recombine because I can't be bothered to re-code it
        $uri = implode('/', $page);

        // Remove trailing slash from the URI for uniform matching
        $uri = rtrim($uri, '/');

        // Track if found yet
        $found = false;

        // Check if there's a matching route
        foreach ($this->getRoutes() as $route) {
            if (($route['method'] === strtoupper($method) || $route['method'] === 'ANY') && $route['route'] === $uri) {
                call_user_func($route['callback']);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->handle404();
        }
    }

    /**
     * Handle a 404 Not Found error.
     *
     * This method loads the 404 page if it exists otherwise returns a default 404 response.
     * 
     * @return void
     */
    private function handle404() {
        if($this->routeExists('ANY', '404')) {
            // If 404 has a route call it
            $this->handleRequest(['404']);
            return;
        }
        header("HTTP/1.1 404 Not Found");
        echo "404 Not Found";
    }
}
