<?php

namespace T4webAdmin\UnitTest;

use T4webAdmin\RouteGenerator;

class RouteGeneratorTest extends \PHPUnit_Framework_TestCase {

    public function testOnRoute()
    {
        $eventMock = $this->getMockBuilder('Zend\Mvc\MvcEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $config = [
            't4web-admin' => [
                'banners' => [
                    'entities' => [
                        'banner',
                    ],
                ],
            ],
        ];

        $routerStack = \Zend\Mvc\Router\Http\TreeRouteStack::factory([]);

        $eventMock->method('getRouter')
            ->will($this->returnValue($routerStack));

        $routeGenerator = new RouteGenerator($eventMock, $config);

        $routeGenerator->generate();

        $compiledRoutes = $routerStack->getRoutes()->toArray();
        $this->assertArrayHasKey('admin-banners-banner', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-banners-banner']);
        $this->assertAttributeContains('/admin/banners/banner', 'regex', $compiledRoutes['admin-banners-banner']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'List',
                'action' => 'list',
                'module' => 'banners',
                'entity' => 'banner',
            ),
            'defaults',
            $compiledRoutes['admin-banners-banner']);
    }

}