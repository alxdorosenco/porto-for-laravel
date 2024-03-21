<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ShipBuilder;
use AlxDorosenco\PortoForLaravel\Structure\Builder\Structure;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;
use PHPUnit\Framework\MockObject\MockObject;

class AbstractStructureClassTest extends TestCase
{
    /**
     * @var Structure|MockObject
     */
    private Structure|MockObject $stub;

    public function setUp(): void
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
    public static function provideBuilderStructure(): array
    {
        $shipBuilder = new ShipBuilder('path', 'Namespace');
        $containerBuilder = new ContainersBuilder('path', 'Namespace');
        $containerBuilder
            ->setContainerName('ContainerName')
            ->setContainerType(ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD->value);

        return [
            'ShipBuilder' => [$shipBuilder],
            'ContainersBuilder' => [$containerBuilder]
        ];
    }

    public function testCreateRootDirectoryMethod(): void
    {
        $this->stub->method('createRootDirectory')
            ->willReturn('root path of the created directory');

        $this->assertEquals('root path of the created directory', $this->stub->createRootDirectory());
    }

    /**
     * @return void
     */
    public function testGetRootDirectoryMethod(): void
    {
        $this->stub->method('getRootDirectory')
            ->willReturn('root path of the created directory');

        $this->assertEquals('root path of the created directory', $this->stub->getRootDirectory());
    }

    public function testBuildMethod(): void
    {
        $this->stub->method('build');
        $this->expectNotToPerformAssertions();
    }

    public function testShowInCliMethod(): void
    {
        $commandClass = new Command();
        $this->stub->method('showInCli')->with($commandClass);

        $this->expectNotToPerformAssertions();
    }

    /**
     * @dataProvider provideBuilderStructure
     * @return void
     */
    public function testGetStructureAbstractMethod(Structure $structure): void
    {
        $this->stub->method('getStructure')
            ->willReturn($structure->getStructure());

        $this->assertEquals($structure->getStructure(), $this->stub->getStructure());
    }
}
