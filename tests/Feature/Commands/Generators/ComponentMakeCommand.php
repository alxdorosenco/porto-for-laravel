<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ComponentMakeCommand extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'inline' => ['inline'],
            'view' => ['view']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:component', [
            'name' => 'TestComponent',
        ])
            ->expectsOutputToContain('Component must be in the container')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestComponent';

        $this->artisan('make:component', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Component ['.$this->portoPath.'/Containers/'.$this->containerName.'/Data/Views/Components/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Views/Components/'.$name.'.php';
        $fileView = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Views/components/test-component.blade.php';

        $this->assertFileExists($file);
        $this->assertFileExists($fileView);
        $this->assertEquals($this->getComponentContent($name, 'components.test-component'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test2'.(ucfirst($type)).'Component';

        if($type === 'view'){
            $output = 'Component created successfully.';
        } else {
            $output = 'Component ['.$this->portoPath.'/Containers/'.$this->containerName.'/Data/Views/Components/'.$name.'.php] created successfully.';
        }

        $this->artisan('make:component', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsOutputToContain($output)
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Views/Components/'.$name.'.php';

        if($type === 'force'){
            $fileView = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Views/components/test2-force-component.blade.php';

            $this->assertFileExists($file);
            $this->assertFileExists($fileView);
            $this->assertEquals($this->getComponentContent($name, 'components.test2-force-component'), file_get_contents($file));
        }

        if($type === 'inline'){
            $this->assertFileExists($file);
        }

        if($type === 'view'){
            $fileView = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Views/components/test2-view-component.blade.php';
            $this->assertFileExists($fileView);
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getComponentContent(string $name, string $view): string
    {
        $viewContainer = strtolower(str_replace('/', '@',  $this->containerName));

        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Views\Components;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Views\Component;

class $name extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('$viewContainer::$view');
    }
}
";
    }
}
