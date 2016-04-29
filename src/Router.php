<?php
namespace LancerHe\Router;

use LancerHe\Router\Routes\Route;

/**
 * Router
 *
 * Takes a URL and routes it to a controller
 *
 * @author James Moss <email@jamesmoss.co.uk>
 */
class Router {
    /**
     * Holds the request obj
     *
     * @var Request
     */
    protected $_request = null;
    /**
     * An array of the route regexes
     *
     * @var Route[]
     */
    protected $_routes = [];

    /**
     * Router constructor.
     *
     * @param        $uri
     * @param string $method
     */
    public function __construct($uri, $method = '*') {
        // Validate the method
        if ( $method != '*' && ! $this->isValidHttpMethod($method) ) {
            throw new \InvalidArgumentException('Invalid HTTP method: ' . $method);
        }
        $this->_request = new Request($uri, $method);
    }

    /**
     * @param      $route
     * @param null $action
     * @return $this
     */
    public function add($route, $action = null) {
        if ( is_string($route) ) {
            $route = new Routes\Basic($route, $action);
        }
        $route->add($this->_routes);
        return $this;
    }

    /**
     * Matches a route against a request
     *
     * @author James Moss
     * @return Match
     */
    public function match() {
        // Loop over the routes and check each one
        foreach ( $this->_routes as $route ) {
            if ( $route->match($this->_request) ) {
                return new Match($this->_request, $route);
            }
        }
        return false;
    }

    /**
     * @param $method
     * @return bool
     */
    protected function isValidHttpMethod($method) {
        $allowed = explode(',', 'GET,POST,PUT,DELETE,HEAD,TRACE,OPTIONS,CONNECT,PATCH');
        return in_array(strtoupper($method), $allowed);
    }
}