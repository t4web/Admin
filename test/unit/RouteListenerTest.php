<?php

namespace T4webAdmin\UnitTest;

use T4webAdmin\RouteListener;

class RouteListenerTest extends \PHPUnit_Framework_TestCase {

    public function testOnRoute()
    {
        $routeListener = new RouteListener();

        $appMock = $this->getMockBuilder('Zend\Mvc\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $smMock = $this->getMockBuilder('\Zend\ServiceManager\ServiceLocatorInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $eventMock = $this->getMockBuilder('Zend\Mvc\MvcEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $eventMock->method('getApplication')
            ->will($this->returnValue($appMock));

        $appMock->method('getServiceManager')
            ->will($this->returnValue($smMock));

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

        $smMock->method('get')
            ->with('config')
            ->will($this->returnValue($config));

        $routeListener->onRoute($eventMock);

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