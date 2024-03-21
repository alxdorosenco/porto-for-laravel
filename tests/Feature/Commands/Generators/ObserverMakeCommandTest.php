<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ObserverMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function provideTypes(): array
    {
        return [
            'force' => ['force'],
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
        $this->artisan('make:observer', [
            'name' => 'TestObserver',
        ])
            ->expectsOutputToContain('Observer must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestObserver';

        $this->artisan('make:observer', [
            'name' => 'TestObserver',
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Observer ['.$this->portoPath.'/Containers/'.$this->containerName.'/Observers/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Observers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getObserverContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Observer';
        $modelName = 'ModelForObserver';

        $this->artisan('make:observer', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $type === 'model' ? $modelName : true
        ])
            ->expectsOutputToContain('Observer ['.$this->portoPath.'/Containers/'.$this->containerName.'/Observers/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Observers/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'model'){
            $this->assertEquals($this->getObserverModelContent($name, $modelName), file_get_contents($file));
        } else {
            $this->assertEquals($this->getObserverContent($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getObserverContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Observers;

class $name
{
    //
}

Class;

    }

    /**
     * @param string $name
     * @param string $model
     * @return string
     */
    private function getObserverModelContent(string $name, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Observers;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;

class $name
{
    /**
     * Handle the $model \"created\" event.
     */
    public function created($model ".'$'."$modelVariable): void
    {
        //
    }

    /**
     * Handle the $model \"updated\" event.
     */
    public function updated($model ".'$'."$modelVariable): void
    {
        //
    }

    /**
     * Handle the $model \"deleted\" event.
     */
    public function deleted($model ".'$'."$modelVariable): void
    {
        //
    }

    /**
     * Handle the $model \"restored\" event.
     */
    public function restored($model ".'$'."$modelVariable): void
    {
        //
    }

    /**
     * Handle the $model \"force deleted\" event.
     */
    public function forceDeleted($model ".'$'."$modelVariable): void
    {
        //
    }
}
";
    }
}
