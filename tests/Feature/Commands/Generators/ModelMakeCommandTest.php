<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ModelsContent;

class ModelMakeCommandTest extends TestCase
{
    use ModelsContent;

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
        ])
            ->expectsOutputToContain('Model must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestModel';

        $this->artisan('make:model', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Factory ['.$this->portoPath.'/Containers/'.$this->containerName.'/Models/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Models/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getModelContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $modelName = 'Test'.(ucfirst($type)).'Model';

        $testCommand = $this->artisan('make:model', [
            'name' => $modelName,
            '--container' => $this->containerName,
            '--'.$type => true
        ]);

        $testCommand->assertSuccessful();
    }
}
