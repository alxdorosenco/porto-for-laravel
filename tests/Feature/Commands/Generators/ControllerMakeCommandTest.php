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
            'force' => ['force'],
            'invokable' => ['invokable'],
            'model' => ['model'],
            'parent' => ['parent'],
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
        $this->artisan('make:controller', [
            'name' => 'Test1Controller',
            '--container' => $this->containerName
        ])->assertExitCode(0);
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

        $testCommand = $this->artisan('make:controller', [
            'name' => 'Test2'.(ucfirst($type)),
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ]);

        if($type === 'model' || $type === 'parent'){
            $namespace = ucfirst(config('porto.path')).'\Containers\\'.$this->containerName.'\Models\\'.$typeValue;
            $testCommand->expectsQuestion("A {$namespace} model does not exist. Do you want to generate it?", 'yes');
        }

        $testCommand->assertExitCode(0);
    }
}
