<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Structure\Builder\ShipBuilder;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ShipBuilderClassTest extends TestCase
{
    /**
     * @var ShipBuilder
     */
    private $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = new ShipBuilder('path', 'Namespace');
    }

    /**
     * @return void
     */
    public function testGetStructureMethod(): void
    {
        $this->assertFileExists($this->builder->getComponent('ship'));
        $this->assertIsArray($this->builder->getStructure());
    }
}
