<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ConfigMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $name = 'TestConfig';

        $commandStatus = $this->artisan('make:config', [
            'name' => $name
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Configs/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConfigContent(), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $name = 'Test2Config';

        $commandStatus = $this->artisan('make:config', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

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
