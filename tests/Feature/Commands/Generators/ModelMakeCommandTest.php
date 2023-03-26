<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ControllersContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\FactoryContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ModelsContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\PolicyContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\SeedContent;
use Illuminate\Support\Str;

class ModelMakeCommandTest extends TestCase
{
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
            'controller-api' => ['controllerApi'],
            'factory' => ['factory'],
            'force' => ['force'],
            'migration' => ['migration'],
            'policy' => ['policy'],
            'seed' => ['seed'],
            'pivot' => ['pivot'],
            'resource' => ['resource'],
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
        $name = 'TestModel';

        $this->artisan('make:model', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertSuccessful();

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
            '--container' => $this->containerName
        ];

        if($type === 'controllerApi'){
            $params['--controller'] = true;
            $params['--api'] = true;
        } else {
            $params['--'.$type] = true;
        }

        $this->artisan('make:model', $params)
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Models/'.$name.'.php';

        $this->assertFileExists($file);

        $controllerName = Str::studly(class_basename($name)).'Controller';

        if($type === 'all'){
            $factoryName = Str::studly($name).'Factory';
            $seedName = Str::studly(class_basename($name)).'Seeder';
            $policyName = Str::studly(class_basename($name)).'Policy';

            $factoryFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Factories/'.$factoryName.'.php';
            $seedFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Seeders/'.$seedName.'.php';
            $controllerFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$controllerName.'.php';
            $policyFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Policies/'.$policyName.'.php';

            $this->assertFileExists($factoryFile);
            $this->assertFileExists($seedFile);
            $this->assertFileExists($controllerFile);
            $this->assertFileExists($policyFile);

            $this->assertEquals($this->getModelContent($name), file_get_contents($file));

            $this->assertEquals($this->getFactoryContent($factoryName, 'Containers\\'.$this->containerName.'\Models\\'.$name), file_get_contents($factoryFile));
            $this->assertEquals($this->getSeederContent($seedName, 'Containers\\'.$this->containerName.'\Data\Seeders'), file_get_contents($seedFile));
            $this->assertEquals($this->getControllerModelRequestContent($controllerName, 'Containers\\'.$this->containerName.'\UI\WEB\Controllers', $name), file_get_contents($controllerFile));
            $this->assertEquals($this->getPolicyModelContent($policyName, $name), file_get_contents($policyFile));
        } elseif($type === 'controller'){
            $controllerFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$controllerName.'.php';

            $this->assertFileExists($controllerFile);
            $this->assertEquals($this->getControllerPlainContent($controllerName, 'Containers\\'.$this->containerName.'\UI\WEB\Controllers'), file_get_contents($controllerFile));
        }elseif($type === 'controllerApi'){
            $controllerFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Controllers/'.$controllerName.'.php';

            $this->assertFileExists($controllerFile);
            $this->assertEquals($this->getControllerModelApiContent($controllerName, 'Containers\\'.$this->containerName.'\UI\API\Controllers', $name), file_get_contents($controllerFile));
        } elseif($type === 'pivot'){
            $this->assertEquals($this->getModelPivotContent($name), file_get_contents($file));
        } elseif ($type === 'morph-pivot'){
            $this->assertEquals($this->getModelMorphPivotContent($name), file_get_contents($file));
        } else {
            $this->assertEquals($this->getModelContent($name), file_get_contents($file));
        }
    }
}
