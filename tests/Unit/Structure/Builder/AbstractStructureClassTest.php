<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ShipBuilder;
use AlxDorosenco\PortoForLaravel\Structure\Builder\Structure;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class AbstractStructureClassTest extends TestCase
{
    /**
     * @var Structure|(Structure&MockObject)|MockObject
     */
    private $stub;

    public function setUp()
    {
        parent::setUp();

        $this->stub = $this->getMockBuilder(Structure::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
    }

    /**
     * @return array
     */
    public function provideBuilderStructure(): array
    {
        $shipBuilder = new ShipBuilder('path', 'Namespace');
        $containerBuilder = new ContainersBuilder('path', 'Namespace');
        $containerBuilder
            ->setContainerName('ContainerName')
            ->setContainerType(ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD);

        return [
            'ShipBuilder' => [$shipBuilder],
            'ContainersBuilder' => [$containerBuilder]
        ];
    }

    public function testCreateRootDirectoryMethod()
    {
        $this->stub->method('createRootDirectory')
            ->willReturn('root path of the created directory');

        $this->assertEquals('root path of the created directory', $this->stub->createRootDirectory());
    }

    /**
     * @return void
     */
    public function testGetRootDirectoryMethod()
    {
        $this->stub->method('getRootDirectory')
            ->willReturn('root path of the created directory');

        $this->assertEquals('root path of the created directory', $this->stub->getRootDirectory());
    }

    /**
     * @dataProvider provideBuilderStructure
     * @return void
     */
    public function testGetStructureAbstractMethod(Structure $structure)
    {
        $this->stub->method('getStructure')
            ->willReturn($structure->getStructure());

        $this->assertEquals($structure->getStructure(), $this->stub->getStructure());
    }
}
