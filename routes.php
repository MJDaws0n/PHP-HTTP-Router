<?php
$router->addRoute('GET', '', function() { // GET to /
    echo "Home page at /";
});
$router->addRoute('GET', 'otherpage', function() { // GET to /otherpage
    echo "Other page at /otherpage";
});
$router->addRoute('ANY', '404', function() { // Any request type to /404 or when a route not found
    echo "Error page not found.";
});

// API routes example
$router->addRoute('POST', 'api/auth/login', function() { // POST to /api/auth/login
    echo "Api page for /api/auth/login";
});
$router->addRoute('GET', 'api/users', function() { // GET to /api/users
    echo "This is the users page";
});
