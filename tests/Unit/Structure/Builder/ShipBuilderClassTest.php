<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure\Builder;

use AlxDorosenco\PortoForLaravel\Structure\Builder\ShipBuilder;
use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ShipBuilderClassTest extends TestCase
{
    /**
     * @var ShipBuilder
     */
    private $builder;

    public function setUp()
    {
        parent::setUp();

        $this->builder = new ShipBuilder('path', 'Namespace');
    }

    /**
     * @return void
     */
    public function testGetStructureMethod()
    {
        $this->assertFileExists($this->builder->getComponent('ship'));

        $isArray = is_array($this->builder->getStructure());
        $this->assertTrue($isArray);
    }
}
