<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Unit\Structure;

use AlxDorosenco\PortoForLaravel\Structure\Builder\Structure;
use AlxDorosenco\PortoForLaravel\Structure\StructureMaker;
use PHPUnit\Framework\TestCase;
use Illuminate\Console\Command;

class StructureMakerClassTest extends TestCase
{
    public function testExecuteMethod()
    {
        $command = new Command();

        $structure = $this->getMockBuilder(Structure::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $structureMaker = new StructureMaker($command, $structure);

        $this->assertTrue(
            method_exists($structureMaker, 'execute'),
            'Class does not have method execute'
        );
    }
}
