<?php

namespace T4webAdmin\UnitTest;

use T4webAdmin\ConfigFactory;

class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $applicationMock = $this->getMockBuilder('Zend\Mvc\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocatorMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocatorMock->expects($this->at(0))
            ->method('get')
            ->with("Application")
            ->willReturn($applicationMock);

        $eventMock = $this->getMockBuilder('Zend\Mvc\MvcEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $routeMatchMock = $this->getMockBuilder('Zend\Mvc\Router\Http\RouteMatch')
            ->disableOriginalConstructor()
            ->getMock();

        $applicationMock->expects($this->once())
            ->method('getMvcEvent')
            ->willReturn($eventMock);

        $eventMock->expects($this->once())
            ->method('getRouteMatch')
            ->willReturn($routeMatchMock);

        $module = 'tasks';
        $routeMatchMock->expects($this->at(0))
            ->method('getParam')
            ->with("module")
            ->willReturn($module);

        $entity = 'task';
        $routeMatchMock->expects($this->at(1))
            ->method('getParam')
            ->with("entity")
            ->willReturn($entity);

        $action = 'list';
        $routeMatchMock->expects($this->at(2))
            ->method('getParam')
            ->with("__CONTROLLER__")
            ->willReturn($action);

        $serviceLocatorMock->expects($this->at(1))
            ->method('has')
            ->with("config")
            ->willReturn(true);

        $serviceLocatorMock->expects($this->at(2))
            ->method('get')
            ->with("config")
            ->willReturn([]);

        $factory = new ConfigFactory();

        $service = $factory->createService($serviceLocatorMock);

        $this->assertInstanceOf('T4webAdmin\Config', $service);
        $this->assertEquals($module, $service->getModule());
        $this->assertEquals($entity, $service->getEntity());
        $this->assertEquals($action, $service->getAction());
    }
}