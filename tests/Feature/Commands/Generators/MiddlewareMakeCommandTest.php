<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class MiddlewareMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestMiddleware';

        $this->artisan('make:middleware', [
            'name' => $name
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Ship/Middleware/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getMiddlewareContent($name, 'Ship\Middleware'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestMiddleware';

        $this->artisan('make:middleware', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Middleware/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getMiddlewareContent($name, 'Containers\\'.$this->containerName.'\Middleware'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getMiddlewareContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Requests\Request;
use Closure;

class $name
{
    /**
     * Handle an incoming request.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \Closure(\\{$this->portoPathUcFirst()}\Ship\Requests\Request): (\\{$this->portoPathUcFirst()}\Ship\Responses\Response|\\{$this->portoPathUcFirst()}\Ship\Responses\RedirectResponse)  ".'$next'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response|\\{$this->portoPathUcFirst()}\Ship\Responses\RedirectResponse
     */
    public function handle(Request ".'$request'.", Closure ".'$next'.")
    {
        return ".'$next'."(".'$request'.");
    }
}
";
    }
}
