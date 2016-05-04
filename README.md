# Routa

A RESTful, flexible MVC router component for PHP 5.4+.  Declare rules which route HTTP requests to a controller.

## Do we need another router?

There's loads of router components so why do we need another? Many of the existing   ones are tightly coupled, poorly written. Routa is built with the following in mind:

- RESTful
- Loosely coupled
- Inspired by Ruby on Rails
- Compatible with PHP >= 5.3
- Prefers convention over configuration
- Flexible and extendable
- Automated test suite

## Installation

Routa adheres to the [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) spec. If you have a compatible autoloader place the contents of `lib` in your vendor directory.

## Basic usage

Within your code create a new instance of the router class. 

    $router = new LancerHe\Router\Router;

This approach automatically uses the current page URL and HTTP method from the $_SERVER super global, it's possible to override this which we'll cover later.

Next add some routes to map URLs to controller names/actions:

    $router
        ->add('GET', '/login', 'v1#Account#login')
        ->add('GET', '/profile/:id', 'v1#User#view')
        ->add('GET', '/profile/:id/edit', 'v1#User#edit')
        ->add('GET', '/search/*', 'v1#Products#search');

Once all your routes have been declared match your request against them.

    if($result = $router->match()) {
        // Assuming the url is /profile/432
        var_dump($result->getModuleName()); // returns 'v1'
        var_dump($result->getControllerName()); // returns 'User'
        var_dump($result->getActionName()); // returns 'view'
        var_dump($result->getParams); // returns ['id' => 432]
        // Load your controller… 
    } else {
        // Display your 404 page.
    }



