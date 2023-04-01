<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;
use AlxDorosenco\PortoForLaravel\Tests\Traits\FactoryContent;

class FactoryMakeCommandTest extends TestCase
{
    use FactoryContent;

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
        ])->assertExitCode(Command::FAILURE);
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
        ])->assertExitCode(Command::SUCCESS);

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
        ])->assertExitCode(Command::SUCCESS);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getFactoryContent($name, 'Containers\\'.$this->containerName.'\Models\\'.$modelName), file_get_contents($file));
    }
}
