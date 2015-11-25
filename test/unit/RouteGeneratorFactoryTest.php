<?php

namespace T4webAdmin\UnitTest;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\MvcEvent;
use T4webAdmin\RouteGeneratorFactory;

class RouteGeneratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServiceManager  */
    protected $serviceManager;

    public function setUp()
    {
        $this->serviceManager = new ServiceManager();
    }

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