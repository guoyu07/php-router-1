<?php
namespace LancerHe\Router;

use LancerHe\Router\Routes\Route;

/**
 * Route
 *
 * Parses a route so that it can be used to determine which controller to load.
 *
 * @author James Moss <email@jamesmoss.co.uk>
 */
class Match {
    /**
     * @var string
     */
    protected $_delimiter = '#';
    /**
     * @var string
     */
    protected $_moduleName = '';
    /**
     * @var string
     */
    protected $_controllerName = '';
    /**
     * @var string
     */
    protected $_actionName = '';
    /**
     * @var array
     */
    protected $_params = [];

    /**
     * Match constructor.
     *
     * @param       $request
     * @param Route $route
     */
    public function __construct($request, $route) {
        list($this->_moduleName, $this->_controllerName, $this->_actionName) = explode($this->_delimiter, $route->getDispatchingRule());
        $this->_params = $route->getParams();
    }

    /**
     * @param $key
     * @return string|false
     */
    public function getParam($key) {
        return isset($this->_params[$key]) ? $this->_params[$key] : false;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * @return string
     */
    public function getModuleName() {
        return $this->_moduleName;
    }

    /**
     * @return string
     */
    public function getControllerName() {
        return $this->_controllerName;
    }

    /**
     * @return string
     */
    public function getActionName() {
        return $this->_actionName;
    }
}