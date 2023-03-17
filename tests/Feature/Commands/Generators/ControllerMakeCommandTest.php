<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class ControllerMakeCommandTest extends TestCase
{
    use FilesAndDirectories;

    /**
     * @return \string[][]
     */
    protected function provideTypes(): array
    {
        return [
            'api' => ['api'],
            'force' => ['force'],
            'invokable' => ['invokable'],
            'model' => ['model'],
            'parent' => ['parent'],
            'resource'  => ['resource'],
            'requests'  => ['requests'],
            'singleton' => ['singleton'],
            'creatable' => ['creatable']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:controller', [
            'name' => 'TestController',
        ])->assertFailed();
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
        ])->assertSuccessful();
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

        if($type === 'parent' || $type === 'model'){
            $namespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$typeValue);
            $testCommand->expectsConfirmation('A '.$namespace.' model does not exist. Do you want to generate it?', 'yes');
        }

        $testCommand->assertSuccessful();
    }
}
