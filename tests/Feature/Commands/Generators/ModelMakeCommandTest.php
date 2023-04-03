<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ControllersContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\FactoryContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ModelsContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\PolicyContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\SeedContent;
use Illuminate\Support\Str;

class ModelMakeCommandTest extends TestCase
{
    use FilesAndDirectories;
    use ModelsContent;
    use FactoryContent;
    use SeedContent;
    use ControllersContent;
    use PolicyContent;

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
            'pivot' => ['pivot'],
            'resource' => ['resource']
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
        ])->assertExitCode(0);
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
        ])->assertExitCode(0);

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
        $name = 'Test'.(ucfirst($type)).'Model';

        $params = [
            'name' => $name,
            '--'.$type => true,
            '--container' => $this->containerName
        ];

        $this->createDirectory(base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Migrations');

        $this->artisan('make:model', $params)
            ->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Models/'.$name.'.php';

        $this->assertFileExists($file);

        $controllerName = Str::studly(class_basename($name)).'Controller';

        if($type === 'all'){
            $factoryName = Str::studly($name).'Factory';

            $factoryFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$factoryName.'.php';
            $controllerFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$controllerName.'.php';

            $this->assertFileExists($factoryFile);
            $this->assertFileExists($controllerFile);

            $this->assertEquals($this->getModelContent($name), file_get_contents($file));

            $this->assertEquals($this->getFactoryContent('Containers\\'.$this->containerName.'\Models\\'.$name, $name), file_get_contents($factoryFile));
            $this->assertEquals($this->getControllerModelRequestContent($controllerName, 'Containers\\'.$this->containerName.'\UI\WEB\Controllers', $name), file_get_contents($controllerFile));
        } elseif($type === 'controller'){
            $controllerFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$controllerName.'.php';

            $this->assertFileExists($controllerFile);
            $this->assertEquals($this->getControllerPlainContent($controllerName, 'Containers\\'.$this->containerName.'\UI\WEB\Controllers'), file_get_contents($controllerFile));
        } elseif($type === 'pivot'){
            $this->assertEquals($this->getModelPivotContent($name), file_get_contents($file));
        } else {
            $this->assertEquals($this->getModelContent($name), file_get_contents($file));
        }
    }
}
