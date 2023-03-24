<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class PolicyMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'model' => ['model'],
            'guard' => ['guard']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:policy', [
            'name' => 'TestPolicy',
        ])
            ->expectsOutputToContain('Policy must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestPolicy';

        $this->artisan('make:policy', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Policy ['.$this->portoPath.'/Containers/'.$this->containerName.'/Policies/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Policies/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getPolicyContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Policy';
        $modelName = 'ModelForPolicy';
        $guardName = 'GuardForPolicy';

        $params = [
            'name' => $name,
            '--container' => $this->containerName,
        ];

        if($type === 'model'){
            $params['--'.$type] = $modelName;
        }

        if($type === 'guard'){
            $params['--'.$type] = $guardName;
            $this->expectException(\LogicException::class);
        }

        $this->artisan('make:policy', $params)
            ->expectsOutputToContain('Policy ['.$this->portoPath.'/Containers/'.$this->containerName.'/Policies/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Policies/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'model'){
            $this->assertEquals($this->getPolicyModelContent($name, $modelName), file_get_contents($file));
        } else {
            $this->assertEquals($this->getPolicyContent($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getPolicyContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Policies;

use {$this->portoPathUcFirst()}\Ship\Models\UserModel;
use {$this->portoPathUcFirst()}\Ship\Policies\Policy;

class $name extends Policy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}

Class;

    }

    /**
     * @param string $name
     * @param string $model
     * @return string
     */
    private function getPolicyModelContent(string $name, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Policies;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Models\UserModel;

class $name extends Policy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(UserModel ".'$userModel'.")
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserModel ".'$userModel'.")
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }
}
