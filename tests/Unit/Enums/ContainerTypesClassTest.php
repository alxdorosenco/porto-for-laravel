<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Enums;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use PHPUnit\Framework\TestCase;

class ContainerTypesClassTest extends TestCase
{
    public function testConstantValues(): void
    {
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_DEFAULT, ContainerTypes::from('default'));
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_FULL, ContainerTypes::from('full'));
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD, ContainerTypes::from('standard'));
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_API, ContainerTypes::from('api'));
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_WEB, ContainerTypes::from('web'));
        $this->assertEquals(ContainerTypes::PORTO_CONTAINER_TYPE_CLI, ContainerTypes::from('cli'));
    }
}
