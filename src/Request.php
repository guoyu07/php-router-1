<?php
namespace LancerHe\Router;

/**
 * Class Request
 *
 * @package LancerHe\Router
 * @author  Lancer He <lancer.he@gmail.com>
 */
class Request {
    /**
     * @var null|string
     */
    protected $_uri = null;
    /**
     * @var null|string
     */
    protected $_method = null;

    /**
     * Request constructor.
     *
     * @param string $uri
     * @param string $method
     */
    public function __construct($uri, $method) {
        $this->_uri    = $uri;
        $this->_method = strtoupper($method);
    }

    /**
     * @return null|string
     */
    public function getUri() {
        return $this->_uri;
    }

    /**
     * @return null|string
     */
    public function getMethod() {
        return $this->_method;
    }
}