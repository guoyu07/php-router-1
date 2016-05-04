<?php
namespace LancerHe\Router\Test;

use LancerHe\Router\Router;
use PHPUnit_Framework_TestCase;

/**
 * Class RouterTest
 *
 * @package LancerHe\Router\Test
 * @author  Lancer He <lancer.he@gmail.com>
 */
class RouterTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function undefined_router() {
        $r = new Router('/users/list/all', 'POST');
        $this->assertFalse($r->match());
    }

    /**
     * @test
     */
    public function basic_route() {
        $url    = '/login';
        $router = new Router($url, 'GET');
        $router
            ->add('GET', '/signup', 'v1#Account#signup')
            ->add('GET', '/login', 'v1#Account#login')
            ->add('GET', '/login/recover', 'v1#Account#recoverPassword')
            ->add('GET', '/logout', 'v1#Account#logout');
        $this->assertInstanceOf('LancerHe\Router\Match', $result = $router->match());
        $this->assertEquals($result->getModuleName(), 'v1');
        $this->assertEquals($result->getControllerName(), 'Account');
        $this->assertEquals($result->getActionName(), 'login');
    }

    /**
     * @test
     */
    public function basic_route_with_tokens() {
        $url    = '/user/233/edit';
        $router = new Router($url, 'POST');
        $router
            ->add('GET', '/user/:id', 'v1#User#view')
            ->add('POST','/user/:id/edit', 'v1#User#save')
            ->add('GET', '/user/:id/edit', 'v1#User#edit');
        $result = $router->match();
        $this->assertEquals($result->getControllerName(), 'User');
        $this->assertEquals($result->getActionName(), 'save');
        $this->assertEquals($result->getParam('id'), '233');
    }
}

?>