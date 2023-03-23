<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class FactoryMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
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

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getFactoryContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Factories;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Factories\Factory;

/**
 * @extends \\{$this->portoPathUcFirst()}\Ship\Abstracts\Factories\Factory<\\{$this->portoPathUcFirst()}\\$namespace>
 */
class $name extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }
}

Class;
    }
}
