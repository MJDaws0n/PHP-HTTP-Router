<?php
require_once 'router.php';
use MJDawson\Router\Router;

define('BASE_DIR', __DIR__);
$router = new Router();

/**
 * Get the current page from the URI
 *
 * @return array
 */
function getPage() {
    return array_values(array_filter(
        explode('/', strtok($_SERVER['REQUEST_URI'], '?')),
        fn($s) => $s !== ''
    ));
}

/**
 * Load a page from /private/pages/{name}.php
 *
 * @param string $name
 * @return void
 */
function loadPage($name) {
    if (!file_exists(BASE_DIR . '/private/pages/' . $name . '.php')) { // Set the dir to whatever 
        die('Page not found: ' . $name);
    }

    $app = ['example' => 'whatever']; // Allows for $app['example'] to return whatever inside the page
    include BASE_DIR . '/private/pages/' . $name . '.php'; // Set the dir to whatever
}

// Define routes
$router->addRoute('GET', '', function() {
    loadPage('home');
});

$router->addRoute('GET', 'about', function() {
    loadPage('about');
});

$router->addRoute('POST', 'api/contact', function() {
    loadPage('api/contact');
});

$router->addRoute('GET', 'api/users', function() {
    loadPage('api/users');
});

$router->addRoute('ANY', '404', function() {
    echo "404 page not found.";
});

// Handle the request
$router->handleRequest(getPage());
