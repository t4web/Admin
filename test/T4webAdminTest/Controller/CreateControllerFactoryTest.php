<?php

namespace T4webAdminTest\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Request;
use T4webAdmin\Controller\CreateControllerFactory;
use T4webAdmin\Config;

class CreateControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $this->markTestIncomplete();
        return;

        $controllerManagerMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocatorMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $controllerManagerMock->expects($this->once())
            ->method('getServiceLocator')
            ->willReturn($serviceLocatorMock);

        $config = new Config([
            'tasks-task' => [
                'module' => 'tasks',
                'entity' => 'task',
                'actions' => [],
            ],
        ]);

        $serviceLocatorMock->expects($this->at(0))
            ->method('get')
            ->with("T4webAdmin\\Config")
            ->willReturn($config);

        $request = new Request();

        $serviceLocatorMock->expects($this->at(1))
            ->method('get')
            ->with("request")
            ->willReturn($request);

        $factory = new CreateControllerFactory();

        $controller = $factory->createService($controllerManagerMock);

        $this->assertInstanceOf('Sebaks\Crud\Controller\CreateController', $controller);
    }
}