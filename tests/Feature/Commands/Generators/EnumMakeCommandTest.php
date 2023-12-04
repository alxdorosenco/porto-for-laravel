<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class EnumMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:enum', [
            'name' => 'TestEnum',
        ])
            ->expectsOutputToContain('Enum must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestEnum';

        $this->artisan('make:enum', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Enum ['.$this->portoPath.'/Containers/'.$this->containerName.'/Enums/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Enums/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getEnumContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getEnumContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Enums;

enum $name
{
    //
}

Class;

    }
}
