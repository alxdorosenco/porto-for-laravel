<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ControllerMakeCommandTest extends TestCase
{
    /**
     * @return \string[][]
     */
    public function provideTypes(): array
    {
        return [
            'api' => ['api'],
            'invokable' => ['invokable'],
            'resource'  => ['resource']
        ];
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $commandStatus = $this->artisan('make:controller', [
            'name' => 'Test1Controller',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $typeValue = true;

        if($type === 'parent'){
            $typeValue = 'ParentController';
        }

        if($type === 'model'){
            $typeValue = 'TestModelForController';
        }

        $commandStatus = $this->artisan('make:controller', [
            'name' => 'Test2'.(ucfirst($type)),
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
