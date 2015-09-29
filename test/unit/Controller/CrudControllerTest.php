<?php

namespace T4webAdmin\UnitTest\Controller\Admin;

use T4webAdmin\Controller\CrudController;
use T4webAdmin\View\Model\ListViewModel;
use T4webBase\Domain\Collection;

class CrudControllerTest extends \PHPUnit_Framework_TestCase {

    public function testListAction()
    {
        return $this->markTestIncomplete();
        $query = ['foo' => 'bar'];
        $filteredQuery = $query;
        $collection = new Collection();

        $inputFilterMock = $this->getMockBuilder('T4webBase\InputFilter\Filter')
            ->disableOriginalConstructor()
            ->getMock();
        $inputFilterMock->method('filter')
            ->with($query)
            ->will($this->returnValue($filteredQuery));

        $finderMock = $this->getMockBuilder('T4webBase\Domain\Service\BaseFinder')
            ->disableOriginalConstructor()
            ->getMock();
        $finderMock->method('findMany')
            ->with($filteredQuery)
            ->will($this->returnValue($collection));

        $listViewModel = new ListViewModel();

        $controller = new CrudController();
        $actualViewModel = $controller->listAction(
            $query,
            $inputFilterMock,
            $finderMock,
            $listViewModel
        );

        $this->assertSame($listViewModel, $actualViewModel);
        $this->assertSame($collection, $actualViewModel->getMainCollection());
    }

}