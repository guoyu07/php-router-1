<?php
namespace LancerHe\Router\Routes;

use LancerHe\Router\Request;

/**
 * Route
 *
 * Describes a URL -> action match
 *
 * @author James Moss <email@jamesmoss.co.uk>
 */
abstract class Route {
    /**
     * The URL to use
     *
     * @var string
     */
    protected $_uri = null;
    /**
     * The name of the controller to return on a match
     *
     * @var string
     */
    protected $_dispatchingRule = null;
    /**
     * The compiled regex URL
     *
     * @var string
     */
    protected $_compiledUrl = '';
    /**
     * @var string
     */
    protected $_method = '';
    /**
     * Route parameters (if any)
     *
     * @var array
     */
    protected $_params = [];
    /**
     * Tokens
     *
     * @var array
     */
    protected $_tokens = [];

    /**
     * Route constructor.
     *
     * @param $method
     * @param $uri
     * @param $dispatchRule
     */
    public function __construct($method, $uri, $dispatchRule) {
        $this->_method          = strtoupper($method);
        $this->_uri             = $uri;
        $this->_dispatchingRule = $dispatchRule;
        $this->_compile();
    }

    /**
     * Takes a request and matches it against this route
     *
     * @author James Moss
     * @param $request
     * @return boolean
     */
    public function match(Request $request) {
        $uri = $request->getUri();
        if ( $this->_method != $request->getMethod() )
            return false;
        if ( $this->_uri === $uri || (count($this->_tokens) && $this->_parseParams($uri)) )
            return true;
        return false;
    }

    /**
     * Return the controller name
     *
     * @author James Moss
     * @return string
     */
    public function getDispatchingRule() {
        return $this->_dispatchingRule;
    }

    /**
     * returns the params
     *
     * @author James Moss
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * @param $routes
     */
    public function add(&$routes) {
        $routes[] = $this;
    }

    /**
     * Turns a human readable route into a regex to match a URL
     *
     * @author James Moss
     */
    protected function _compile() {
        $tokens             = &$this->_tokens; // you cant pass class properties into closures in PHP <= 5.3
        $this->_compiledUrl = str_replace('/', '\/', $this->_uri);
        $this->_compiledUrl = preg_replace_callback(static::PARAMS_REGEX, function ($matches) use (&$tokens) {
            $tokens[] = $matches[1];
            return '([^\/]+?)';
        }, $this->_compiledUrl);
        $this->_compiledUrl = '/^' . $this->_compiledUrl . '$/';
    }

    /**
     * Combines the URL and tokens to make params
     *
     * @author James Moss
     * @param $url
     * @return boolean
     */
    protected function _parseParams($url) {
        if ( count($this->_params) ) {
            return true;
        }
        if ( preg_match_all($this->_compiledUrl, $url, $matches) ) {
            array_shift($matches);
            foreach ( $matches as $i => $match ) {
                $this->_params[$this->_tokens[$i]] = $match[0];
            }
            return true;
        }
        return false;
    }
}