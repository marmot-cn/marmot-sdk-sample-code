<?php
namespace Sample\Sdk\Common\Repository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sample\Sdk\News\Utils\ObjectGenerate;

use Sample\Sdk\Common\Adapter\IFetchAbleAdapter;

class FetchRepositoryTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestFetchRepository::class)
                    ->setMethods(['getAdapter'])->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testFetchOne()
    {
        $id = 1;
        $news = ObjectGenerate::generateNews($id);

        $adapter = $this->prophesize(IFetchAbleAdapter::class);
        $adapter->fetchOne(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn($news);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($news, $result);
    }

    public function testFetchList()
    {
        $ids = [1,2,3];
        $news = array(
            ObjectGenerate::generateNews(1),
            ObjectGenerate::generateNews(2)
        );

        $adapter = $this->prophesize(IFetchAbleAdapter::class);
        $adapter->fetchList(Argument::exact($ids))->shouldBeCalledTimes(1)->willReturn($news);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->fetchList($ids);
        $this->assertEquals($news, $result);
    }

    public function testSearch()
    {
        $filter = array();
        $sort = array();
        $number = 1;
        $size = 10;

        $news = array(
            ObjectGenerate::generateNews(1),
            ObjectGenerate::generateNews(2)
        );

        $adapter = $this->prophesize(IFetchAbleAdapter::class);
        $adapter->search(
            Argument::exact($filter),
            Argument::exact($sort),
            Argument::exact($number),
            Argument::exact($size)
        )->shouldBeCalledTimes(1)->willReturn($news);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->search($filter, $sort, $number, $size);

        $this->assertEquals($news, $result);
    }
}
