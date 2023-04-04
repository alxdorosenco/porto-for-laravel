<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ConfigMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestConfig';

        $this->artisan('make:config', [
            'name' => $name
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Ship/Configs/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConfigContent(), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'Test2Config';

        $this->artisan('make:config', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Configs/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConfigContent(), file_get_contents($file));
    }

    /**
     * @return string
     */
    private function getConfigContent(): string
    {
        return <<<FILE
<?php

return [
   // config arrays
];

FILE;

    }
}
