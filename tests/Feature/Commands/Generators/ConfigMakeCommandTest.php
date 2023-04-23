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
    public function testConsoleCommand(): void
    {
        $name = 'TestConfig';

        $this->artisan('make:config', [
            'name' => $name
        ])
            ->expectsOutputToContain('Config ['.$this->portoPath.'/Ship/Configs/'.$name.'.php] created successfully.')
            ->assertSuccessful();

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
        ])
            ->expectsOutputToContain('Config ['.$this->portoPath.'/Containers/'.$this->containerName.'/Configs/'.$name.'.php] created successfully.')
            ->assertSuccessful();

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
