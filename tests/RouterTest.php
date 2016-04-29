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
     * @expectedException \InvalidArgumentException
     */
    public function invalid_http_method() {
        new Router('/users/list', 'POKE');
    }

    /**
     * @test
     */
    public function valid_http_method() {
        new Router('/users/edit/123', 'POST');
    }

    /**
     * @test
     */
    public function undefined_router() {
        $r = new Router('/users/list/all');
        $this->assertFalse($r->match());
    }

    /**
     * @test
     */
    public function basic_route() {
        $url    = '/login';
        $router = new Router($url);
        $router
            ->add('/signup', 'v1#Account#signup')
            ->add('/login', 'v1#Account#login')
            ->add('/login/recover', 'v1#Account#recoverPassword')
            ->add('/logout', 'v1#Account#logout');
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
        $router = new Router($url);
        $router
            ->add('/user/:id', 'v1#User#view')
            ->add('/user/:id/edit', 'v1#User#edit');
        $result = $router->match();
        $this->assertEquals($result->getControllerName(), 'User');
        $this->assertEquals($result->getActionName(), 'edit');
        $this->assertEquals($result->getParam('id'), '233');
    }
}

?>