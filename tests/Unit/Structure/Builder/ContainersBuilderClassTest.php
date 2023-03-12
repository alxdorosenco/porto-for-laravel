<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use AlxDorosenco\PortoForLaravel\Structure\Builder\ContainersBuilder;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ContainersBuilderClassTest extends TestCase
{
    /**
     * @var ContainersBuilder
     */
    private $builder;

    public function setUp()
    {
        parent::setUp();

        $this->builder = new ContainersBuilder('path', 'Namespace');
        $this->builder
            ->setContainerName('ContainerName')
            ->setContainerType(ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD);
    }

    /**
     * @return void
     */
    public function testGetContainerNameMethod()
    {
        $this->assertEquals('ContainerName', $this->builder->getContainerName());
    }

    /**
     * @return void
     */
    public function testGetContainerTypeMethod()
    {
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD, $this->builder->getContainerType());
    }

    /**
     * @return void
     */
    public function testGetStructureMethod()
    {
        $isArray = is_array($this->builder->getStructure());
        $this->assertTrue($isArray);
    }
}
