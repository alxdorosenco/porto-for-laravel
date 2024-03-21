<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\FactoryContent;

class FactoryMakeCommandTest extends TestCase
{
    use FactoryContent;

    /**
     * @return array[]
     */
    public static function provideTypes(): array
    {
        return [
            'model' => ['model']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:factory', [
            'name' => 'TestFactory',
        ])
            ->expectsOutputToContain('Factory must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestFactory';

        $this->artisan('make:factory', [
            'name' => 'TestFactory',
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Factory ['.$this->portoPath.'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getFactoryContent($name, 'Ship\Models\Model'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Factory';
        $modelName = 'TestModelForFactory';

        $this->artisan('make:factory', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $modelName
        ])
            ->expectsOutputToContain('Factory ['.$this->portoPath.'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getFactoryContent($name, 'Containers\\'.$this->containerName.'\Models\\'.$modelName), file_get_contents($file));
    }
}
