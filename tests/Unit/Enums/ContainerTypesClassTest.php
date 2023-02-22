<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Enums;

use AlxDorosenco\PortoForLaravel\Enums\ContainerTypes;
use PHPUnit\Framework\TestCase;

class ContainerTypesClassTest extends TestCase
{
    public function testConstantValues(): void
    {
        $this->assertEquals('default', ContainerTypes::PORTO_CONTAINER_TYPE_DEFAULT);
        $this->assertEquals('full', ContainerTypes::PORTO_CONTAINER_TYPE_FULL);
        $this->assertEquals('standard', ContainerTypes::PORTO_CONTAINER_TYPE_STANDARD);
        $this->assertEquals('api', ContainerTypes::PORTO_CONTAINER_TYPE_API);
        $this->assertEquals('web', ContainerTypes::PORTO_CONTAINER_TYPE_WEB);
        $this->assertEquals('cli', ContainerTypes::PORTO_CONTAINER_TYPE_CLI);
    }
}
