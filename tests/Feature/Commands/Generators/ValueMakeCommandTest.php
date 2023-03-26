<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ValueMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:value', [
            'name' => 'TestValue',
        ])->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestValue';

        $this->artisan('make:value', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Values/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getValueContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getValueContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Values;

class $name
{
    // value class
}

Class;

    }
}
