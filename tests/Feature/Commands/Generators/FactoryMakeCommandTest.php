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
    public function testConsoleCommand()
    {
        $commandStatus = $this->artisan('make:factory', [
            'name' => 'TestFactory',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $name = 'TestFactory';

        $commandStatus = $this->artisan('make:factory', [
            'name' => 'TestFactory',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getFactoryContent('Ship\Models\Model', 'Model'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type)
    {
        $name = 'Test'.(ucfirst($type)).'Factory';
        $modelName = 'TestModelForFactory';

        $commandStatus = $this->artisan('make:factory', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $modelName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getFactoryContent('Containers\\'.$this->containerName.'\Models\\'.$modelName, $modelName), file_get_contents($file));
    }
}
