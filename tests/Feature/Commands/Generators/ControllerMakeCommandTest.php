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
            'model-api' => ['modelApi'],
            'parent' => ['parent'],
            'parent-singleton' => ['parentSingleton'],
            'parent-api' => ['parentApi'],
            'parent-singleton-api' => ['parentSingletonApi'],
            'resource'  => ['resource'],
            'requests'  => ['requests'],
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
        }  elseif($type === 'parent'){
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestModel');
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestParentModel');

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => 'TestModel',
                '--parent' => 'TestParentModel'
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedContent($name, $namespace, 'TestModel', 'TestParentModel'), file_get_contents($file));
        } elseif($type === 'parentSingleton') {
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestSingletonModel');
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestParentSingletonModel');

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => 'TestSingletonModel',
                '--parent' => 'TestParentSingletonModel',
                '--singleton' => true
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedSingletonContent($name, $namespace, 'TestSingletonModel', 'TestParentSingletonModel'), file_get_contents($file));
        } elseif($type === 'parentApi'){
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestApiModel');
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestParentApiModel');

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => 'TestApiModel',
                '--parent' => 'TestParentApiModel',
                '--api' => true
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedApiContent($name, $namespace, 'TestApiModel', 'TestParentApiModel'), file_get_contents($file));
        } elseif($type === 'parentSingletonApi') {
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestSingletonApiModel');
            $parentNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestParentSingletonApiModel');

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => 'TestSingletonApiModel',
                '--parent' => 'TestParentSingletonApiModel',
                '--singleton' => true,
                '--api' => true
            ])
                ->expectsConfirmation('A '.$parentNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerNestedSingletonApiContent($name, $namespace, 'TestSingletonApiModel', 'TestParentSingletonApiModel'), file_get_contents($file));
        } elseif($type === 'model'){
            $modelName = 'TestModelForController';
            $outputModelPath = $this->portoPath.'/Containers/'.$this->containerName.'/Models/'.$modelName.'.php';
            $modelNamespace = $this->getNamespaceFromPath(config('porto.path').'/Containers/'.$this->containerName.'/Models/TestModelForController');
            $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Controllers/'.$name.'.php';

            $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--model' => 'TestModelForController'
            ])
                ->expectsConfirmation('A '.$modelNamespace.' model does not exist. Do you want to generate it?', 'yes')
                ->expectsOutputToContain('Model ['.$outputModelPath.'] created successfully.')
                ->expectsOutputToContain('Controller ['.$outputPath.'] created successfully.')
                ->assertSuccessful();

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerModelContent($name, $namespace, $modelName), file_get_contents($file));
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

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerApiContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show(".'$id'.")
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", ".'$id'.")
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy(".'$id'.")
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerInvokableContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function __invoke(Request ".'$request'.")
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerModelContent(string $name, string $namespace, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerModelApiContent(string $name, string $namespace, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $modelVariable = lcfirst($model);
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedSingletonContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Show the form for creating the new resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create($parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Show the form for editing the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedApiContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $modelVariable = lcfirst($model);
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedSingletonApiContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerSingletonContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Show the form for creating the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.")
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy()
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerSingletonApiContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.")
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy()
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerPlainContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    //
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show(".'$id'.")
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit(".'$id'.")
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", ".'$id'.")
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy(".'$id'.")
    {
        //
    }
}
";
    }
}
