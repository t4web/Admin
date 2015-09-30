<?php

namespace T4webAdmin\UnitTest;

use T4webBaseTest\Factory\AbstractServiceFactoryTest;
use T4webAdmin\RouteGeneratorFactory;
use Zend\Mvc\MvcEvent;

class RouteGeneratorFactoryTest extends AbstractServiceFactoryTest
{

    public function testCreateService()
    {
        $appMock = $this->getMockBuilder('Zend\Mvc\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceManager->setService(
            'Application',
            $appMock
        );

        $config = ['aaa' => 'bbb'];

        $this->serviceManager->setService(
            'config',
            $config
        );

        $mvcEvent = new MvcEvent();

        $appMock->method('getMvcEvent')
            ->will($this->returnValue($mvcEvent));

        $factory = new RouteGeneratorFactory();

        $routeGenerator = $factory->createService($this->serviceManager);

        $this->assertInstanceOf('T4webAdmin\RouteGenerator', $routeGenerator);
        $this->assertAttributeEquals($mvcEvent, 'event', $routeGenerator);
        $this->assertAttributeEquals($config, 'config', $routeGenerator);
    }

}