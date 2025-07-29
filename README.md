# PHP-HTTP-Router
Simple PHP router class I use in my personal projects. No frameworks, just a simple router.

## Setup

```php
// Require the router
require_once 'router.php'; // Or wherever it is at
use MJDawson\Router\Router;

// Init the router
$router = new Router();
```

## Example Usage

In your routes.php or wherever:
```php
// Example for the / page - only triggers on GET requests
$router->addRoute('GET', '', function() {
    echo "Home page at /";
});

// Example for /404 and if the page is not found - will trigger on any request
$router->addRoute('ANY', '404', function() {
    echo "Custom 404 page - Don't add to use default.";
});
```

Then handle the request using:
```php
$router->handleRequest($this->getPage());
```

## Example getPage() function

Here’s a simple function you can use to get the current page:
```php
function getPage(){
  return array_values(array_filter(
      explode('/', strtok($_SERVER['REQUEST_URI'], '?')),
      fn($s) => $s !== ''
  ));
}
```

## Loading Pages
An easy way to load pages that you can use is this loadPage function:
```php
// Do this if you want or not idc. If you don't understand is then you are in the wrong place
define('BASE_DIR', __DIR__ . '/../');

function loadPage($name){
    if (!file_exists(BASE_DIR . '/private/pages/' . $name . '.php')) { // Change this to the to the directory of your pages
        die('Error: Page not found: ' . $name);
    }

    // You can use the $app variable to store values that can be passed Through to the page you just creaetd
    $app = $this; // $this doesn't exists here so this wouldn't actualy work but i'm sure you can firgure out what you want here

    include BASE_DIR . '/private/pages/' . $name . '.php'; // Change this to the to the directory of your pages
}

// Usage
loadPage('home');
loadPage('api/auth/verifyPost');

// Overall example
$router->addRoute('GET', '', function() {
  loadPage('home');
});
```

Then that's it nerd. Enjoy it or not, could not care less what you think about it.


## Note
You only need to copy the router.php file, the routes.php ii an example file.
