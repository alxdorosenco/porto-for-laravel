<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ExceptionMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'render' => ['render'],
            'render-report' => ['renderReport'],
            'report' => ['report']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestException';

        $this->artisan('make:exception', [
            'name' => 'TestException',
        ])
            ->expectsOutputToContain('Exception ['.$this->portoPath.'/Ship/Exceptions/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Ship/Exceptions/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getExceptionContent($name, 'Ship\Exceptions'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'Test2Exception';

        $this->artisan('make:exception', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Exception ['.$this->portoPath.'/Containers/'.$this->containerName.'/Exceptions/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Exceptions/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getExceptionContent($name, 'Containers\\'.$this->containerName.'\Exceptions'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test3'.(ucfirst($type)).'Exception';

        $params = [
            'name' => 'Test3'.(ucfirst($type)).'Exception',
            '--container' => $this->containerName
        ];

        if($type === 'renderReport'){
            $params['--render'] = true;
            $params['--report'] = true;
        } else {
            $params['--'.$type] = true;
        }

        $this->artisan('make:exception', $params)
            ->expectsOutputToContain('Exception ['.$this->portoPath.'/Containers/'.$this->containerName.'/Exceptions/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Exceptions/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'render'){
            $this->assertEquals($this->getExceptionRenderContent($name, 'Containers\\'.$this->containerName.'\Exceptions'), file_get_contents($file));
        } elseif ($type === 'renderReport'){
            $this->assertEquals($this->getExceptionRenderReportContent($name, 'Containers\\'.$this->containerName.'\Exceptions'), file_get_contents($file));
        } elseif ($type === 'report'){
            $this->assertEquals($this->getExceptionReportContent($name, 'Containers\\'.$this->containerName.'\Exceptions'), file_get_contents($file));
        } else {
            $this->assertEquals($this->getExceptionContent($name, 'Containers\\'.$this->containerName.'\Exceptions'), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getExceptionContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use Exception;

class $name extends Exception
{
    //
}

Class;
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getExceptionReportContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use Exception;

class $name extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }
}

Class;
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getExceptionRenderContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Requests\Request;
use {$this->portoPathUcFirst()}\Ship\Responses\Response;
use Exception;

class $name extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request ".'$request'."): Response
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
    private function getExceptionRenderReportContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Requests\Request;
use {$this->portoPathUcFirst()}\Ship\Responses\Response;
use Exception;

class $name extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request ".'$request'."): Response
    {
        //
    }
}
";
    }
}
