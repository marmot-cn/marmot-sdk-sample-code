<?php
namespace Sample\Sdk\Common\Repository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sample\Sdk\News\Utils\ObjectGenerate;
use Sample\Sdk\Common\Adapter\IOperatAbleAdapter;

class OperatAbleRepositoryTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestOperatAbleRepository::class)
            ->setMethods(['getAdapter'])->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testAdd()
    {
        $news = ObjectGenerate::generateNews(1);

        $adapter = $this->prophesize(IOperatAbleAdapter::class);
        $adapter->add(Argument::exact($news))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->add($news);
        $this->assertTrue($result);
    }

    public function testEdit()
    {
        $news = ObjectGenerate::generateNews(1);

        $adapter = $this->prophesize(IOperatAbleAdapter::class);
        $adapter->edit(Argument::exact($news))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->edit($news);
        $this->assertTrue($result);
    }
}
