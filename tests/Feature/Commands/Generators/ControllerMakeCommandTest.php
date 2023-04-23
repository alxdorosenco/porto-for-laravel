<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ControllersContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ModelsContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\RequestsContent;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class ControllerMakeCommandTest extends TestCase
{
    use FilesAndDirectories;
    use ControllersContent;
    use ModelsContent;
    use RequestsContent;

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
            'model-api' => ['modelApi'],
            'model-requests' => ['modelRequests'],
            'model-api-requests' => ['modelApiRequests'],
            'parent' => ['parent'],
            'parent-singleton' => ['parentSingleton'],
            'parent-api' => ['parentApi'],
            'parent-singleton-api' => ['parentSingletonApi'],
            'resource'  => ['resource'],
            'singleton' => ['singleton'],
            'singleton-api' => ['singletonApi'],
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
        ])
            ->expectsOutputToContain('Controller must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestController';

        $this->artisan('make:controller', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Controller ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getControllerPlainContent($name, 'Containers\\'.$this->containerName.'\UI\WEB\Controllers'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test2'.(ucfirst($type)).'Controller';

        $uiType = str_contains($type, 'api') || str_contains($type, 'Api') ? 'API' : 'WEB';
        $outputPath = $this->portoPath.'/Containers/'.$this->containerName.'/UI/'.$uiType.'/Controllers/'.$name.'.php';
        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/'.$uiType.'/Controllers/'.$name.'.php';
        $namespace = 'Containers\\'.$this->containerName.'\UI\\'.$uiType.'\Controllers';

        if($type === 'api'){
            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--api' => true
            ])
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerApiContent($name, $namespace), file_get_contents($file));
        } elseif($type === 'invokable'){
            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--invokable' => true
            ])
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerInvokableContent($name, $namespace), file_get_contents($file));
        } elseif($type === 'model'){
            $modelName = 'TestModelForController';
            $outputModelPath = $this->portoPath.'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$name.'.php';

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName
            ])
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Model ['.$outputModelPath.'] created successfully.')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerModelContent($name, $namespace, $modelName), file_get_contents($file));

            $this->assertFileExists(base_path($outputModelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($outputModelPath)));
        } elseif($type === 'modelApi'){
            $modelName = 'TestModelApiForController';
            $outputModelPath = $this->portoPath.'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Controllers/'.$name.'.php';

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--api' => true
            ])
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Model ['.$outputModelPath.'] created successfully.')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerModelApiContent($name, $namespace, $modelName), file_get_contents($file));

            $this->assertFileExists(base_path($outputModelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($outputModelPath)));
        } elseif($type === 'modelRequests'){
            $modelName = 'TestModelRequestsForController';
            $outputModelPath = $this->portoPath.'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$name.'.php';

            $fileStore = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Requests/Store'.$modelName.'Request.php';
            $fileUpdate = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Requests/Update'.$modelName.'Request.php';

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--requests' => true
            ])
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Model ['.$outputModelPath.'] created successfully.')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerModelRequestContent($name, $namespace, $modelName), file_get_contents($file));

            $this->assertFileExists(base_path($outputModelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($outputModelPath)));

            $this->assertFileExists($fileStore);
            $this->assertEquals($this->getRequestContent('Store'.$modelName.'Request', 'Containers\\'.$this->containerName.'\UI\WEB\Requests'), file_get_contents($fileStore));

            $this->assertFileExists($fileUpdate);
            $this->assertEquals($this->getRequestContent('Update'.$modelName.'Request', 'Containers\\'.$this->containerName.'\UI\WEB\Requests'), file_get_contents($fileUpdate));
        } elseif($type === 'modelApiRequests'){
            $modelName = 'TestModelApiRequestsForController';
            $outputModelPath = $this->portoPath.'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Controllers/'.$name.'.php';

            $fileStore = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Requests/Store'.$modelName.'Request.php';
            $fileUpdate = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/API/Requests/Update'.$modelName.'Request.php';

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--api' => true,
                '--requests' => true
            ])
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Model ['.$outputModelPath.'] created successfully.')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerModelApiRequestContent($name, $namespace, $modelName), file_get_contents($file));

            $this->assertFileExists(base_path($outputModelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($outputModelPath)));

            $this->assertFileExists($fileStore);
            $this->assertEquals($this->getRequestContent('Store'.$modelName.'Request', 'Containers\\'.$this->containerName.'\UI\API\Requests'), file_get_contents($fileStore));

            $this->assertFileExists($fileUpdate);
            $this->assertEquals($this->getRequestContent('Update'.$modelName.'Request', 'Containers\\'.$this->containerName.'\UI\API\Requests'), file_get_contents($fileUpdate));
        } elseif($type === 'parent'){
            $modelName = 'TestSingletonModel';
            $parentModelName = 'TestParentSingletonModel';

            $modelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $parentModelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName.'.php';

            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName);

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--parent' => $parentModelName
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedContent($name, $namespace, $modelName, $parentModelName), file_get_contents($file));

            $this->assertFileExists(base_path($modelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($modelPath)));

            $this->assertFileExists(base_path($parentModelPath));
            $this->assertEquals($this->getModelContent($parentModelName), file_get_contents(base_path($parentModelPath)));
        } elseif($type === 'parentSingleton') {
            $modelName = 'TestSingletonModel';
            $parentModelName = 'TestParentSingletonModel';

            $modelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $parentModelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName.'.php';

            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName);

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--parent' => $parentModelName,
                '--singleton' => true
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedSingletonContent($name, $namespace, $modelName, $parentModelName), file_get_contents($file));

            $this->assertFileExists(base_path($modelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($modelPath)));

            $this->assertFileExists(base_path($parentModelPath));
            $this->assertEquals($this->getModelContent($parentModelName), file_get_contents(base_path($parentModelPath)));
        } elseif($type === 'parentApi'){
            $modelName = 'TestApiModel';
            $parentModelName = 'TestParentApiModel';

            $modelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $parentModelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName.'.php';

            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName);

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--parent' => $parentModelName,
                '--api' => true
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedApiContent($name, $namespace, $modelName, $parentModelName), file_get_contents($file));

            $this->assertFileExists(base_path($modelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($modelPath)));

            $this->assertFileExists(base_path($parentModelPath));
            $this->assertEquals($this->getModelContent($parentModelName), file_get_contents(base_path($parentModelPath)));
        } elseif($type === 'parentSingletonApi') {
            $modelName = 'TestSingletonApiModel';
            $parentModelName = 'TestParentSingletonApiModel';

            $modelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $parentModelPath = config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName.'.php';

            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$modelName);
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/'.$parentModelName);

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => $modelName,
                '--parent' => $parentModelName,
                '--singleton' => true,
                '--api' => true
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedSingletonApiContent($name, $namespace, $modelName, $parentModelName), file_get_contents($file));

            $this->assertFileExists(base_path($modelPath));
            $this->assertEquals($this->getModelContent($modelName), file_get_contents(base_path($modelPath)));

            $this->assertFileExists(base_path($parentModelPath));
            $this->assertEquals($this->getModelContent($parentModelName), file_get_contents(base_path($parentModelPath)));
        } elseif($type === 'resource'){
            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--resource' => true
            ])
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerContent($name, $namespace), file_get_contents($file));
        } elseif($type === 'singleton'){
            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--singleton' => true
            ])
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerSingletonContent($name, $namespace), file_get_contents($file));
        } elseif($type === 'singletonApi'){
            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--singleton' => true,
                '--api' => true
            ])
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerSingletonApiContent($name, $namespace), file_get_contents($file));
        } else {
            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--'.$type => true
            ])
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerPlainContent($name, $namespace), file_get_contents($file));
        }
    }
}
