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
    public function provideTypes(): array
    {
        return [
            'api' => ['api'],
            'invokable' => ['invokable'],
            'resource'  => ['resource']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $commandStatus = $this->artisan('make:controller', [
            'name' => 'TestController',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestController';

        $commandStatus = $this->artisan('make:controller', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

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
        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/'.$uiType.'/Controllers/'.$name.'.php';
        $namespace = 'Containers\\'.$this->containerName.'\UI\\'.$uiType.'\Controllers';

        if($type === 'api'){
            $commandStatus = $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--api' => true
            ]);

            $this->assertEquals(0, $commandStatus);

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerApiContent($name, $namespace), file_get_contents($file));
        } elseif($type === 'invokable'){
            $commandStatus = $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--invokable' => true
            ]);

            $this->assertEquals(0, $commandStatus);

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerInvokableContent($name, $namespace), file_get_contents($file));
        } elseif($type === 'resource'){
            $commandStatus = $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--resource' => true
            ]);

            $this->assertEquals(0, $commandStatus);

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerContent($name, $namespace), file_get_contents($file));
        } else {
            $commandStatus = $this->artisan('make:controller', [
                'name' => $name,
                '--container' => $this->containerName,
                '--'.$type => true
            ]);

            $this->assertEquals(0, $commandStatus);

            $this->assertFileExists($file);
            $this->assertEquals($this->getControllerPlainContent($name, $namespace), file_get_contents($file));
        }
    }
}
