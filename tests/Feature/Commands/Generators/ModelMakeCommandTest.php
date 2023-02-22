<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ModelMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'all' => ['all'],
            'controller' => ['controller'],
            'factory' => ['factory'],
            'force' => ['force'],
            'migration' => ['migration'],
            'morph-pivot' => ['morph-pivot'],
            'policy' => ['policy'],
            'seed' => ['seed'],
            'pivot' => ['pivot'],
            'resource' => ['resource'],
            'api' => ['api'],
            'requests' => ['requests']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:model', [
            'name' => 'TestModel',
        ])->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:model', [
            'name' => 'Test1Model',
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
        $modelName = 'Test2'.(ucfirst($type)).'Model';
        $namespace = config('porto.path').'\Containers\\'.$this->containerName.'\Models\\'.$modelName;

        $testCommand = $this->artisan('make:model', [
            'name' => $type === 'factory' ? 'Test2FModel' : $modelName,
            '--container' => $this->containerName,
            '--'.$type => true
        ]);

        if($type === 'all'){
            $testCommand
                ->expectsConfirmation('A '.$namespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsChoice('Please, select type of the user\'s interface', 'web', ['api' => 'api', 'web' => 'web']);
        }

        if($type === 'resource' || $type === 'api'){
            $testCommand->expectsConfirmation('A '.$namespace.' model does not exist. Do you want to generate it?', 'yes');
        }

        $testCommand->assertSuccessful();
    }
}
