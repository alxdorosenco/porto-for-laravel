<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Enums;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use PHPUnit\Framework\TestCase;

class ContainerTypesClassTest extends TestCase
{
    public function testConstantValues()
    {
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_DEFAULT, 'default');
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_FULL, 'full');
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD, 'standard');
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_API, 'api');
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_WEB, 'web');
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_CLI, 'cli');
    }
}
