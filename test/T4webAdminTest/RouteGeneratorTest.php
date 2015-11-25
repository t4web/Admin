<?php

namespace T4webAdminTest;

use Zend\Mvc\Router\Http\TreeRouteStack;
use T4webAdmin\RouteGenerator;

class RouteGeneratorTest extends \PHPUnit_Framework_TestCase {

    public function testGenerate()
    {
        $eventMock = $this->getMockBuilder('Zend\Mvc\MvcEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $config = [
            't4web-admin' => [
                'tasks-task' => [
                    'module' => 'tasks',
                    'entity' => 'task',
                    'actions' => [],
                ],
            ],
        ];

        $routerStack = TreeRouteStack::factory([]);

        $eventMock->method('getRouter')
            ->will($this->returnValue($routerStack));

        $routeGenerator = new RouteGenerator($eventMock, $config);

        $routeGenerator->generate();

        $compiledRoutes = $routerStack->getRoutes()->toArray();

        // list route
        $this->assertArrayHasKey('admin-tasks-task-list', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-tasks-task-list']);
        $this->assertAttributeContains('/admin/tasks/task/list', 'regex', $compiledRoutes['admin-tasks-task-list']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'list',
                'module' => 'tasks',
                'entity' => 'task',
            ),
            'defaults',
            $compiledRoutes['admin-tasks-task-list']
        );

        // delete route
        $this->assertArrayHasKey('admin-tasks-task-delete', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-tasks-task-delete']);
        $this->assertAttributeContains('/admin/tasks/task/delete', 'regex', $compiledRoutes['admin-tasks-task-delete']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'delete',
                'module' => 'tasks',
                'entity' => 'task',
            ),
            'defaults',
            $compiledRoutes['admin-tasks-task-delete']
        );

        // update route
        $this->assertArrayHasKey('admin-tasks-task-update', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-tasks-task-update']);
        $this->assertAttributeContains('/admin/tasks/task/update', 'regex', $compiledRoutes['admin-tasks-task-update']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'update',
                'module' => 'tasks',
                'entity' => 'task',
            ),
            'defaults',
            $compiledRoutes['admin-tasks-task-update']
        );

        // read route
        $this->assertArrayHasKey('admin-tasks-task-read', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-tasks-task-read']);
        $this->assertAttributeContains('/admin/tasks/task/read', 'regex', $compiledRoutes['admin-tasks-task-read']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'read',
                'module' => 'tasks',
                'entity' => 'task',
            ),
            'defaults',
            $compiledRoutes['admin-tasks-task-read']
        );

        // create route
        $this->assertArrayHasKey('admin-tasks-task-create', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-tasks-task-create']);
        $this->assertAttributeContains('/admin/tasks/task/create', 'regex', $compiledRoutes['admin-tasks-task-create']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'create',
                'module' => 'tasks',
                'entity' => 'task',
            ),
            'defaults',
            $compiledRoutes['admin-tasks-task-create']
        );

        // new route
        $this->assertArrayHasKey('admin-tasks-task-new', $compiledRoutes);
        $this->assertInstanceOf('Zend\Mvc\Router\Http\Segment', $compiledRoutes['admin-tasks-task-new']);
        $this->assertAttributeContains('/admin/tasks/task/new', 'regex', $compiledRoutes['admin-tasks-task-new']);
        $this->assertAttributeEquals(
            array(
                '__NAMESPACE__' => 'T4webAdmin\Controller',
                'controller' => 'new',
                'module' => 'tasks',
                'entity' => 'task',
            ),
            'defaults',
            $compiledRoutes['admin-tasks-task-new']
        );
    }

}