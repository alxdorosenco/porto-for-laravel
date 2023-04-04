<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ProviderMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestProvider';

        $commandStatus = $this->artisan('make:provider', [
            'name' => $name
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Providers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getProviderContent($name, 'Ship\Providers'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestProvider';

        $commandStatus = $this->artisan('make:provider', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Providers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getProviderContent($name, 'Containers\\'.$this->containerName.'\Providers'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getProviderContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Providers\ServiceProvider;

class $name extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

Class;

    }
}
