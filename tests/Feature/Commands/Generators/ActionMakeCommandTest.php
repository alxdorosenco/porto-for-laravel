<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ActionMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:action', [
            'name' => 'TestAction',
        ])
            ->expectsOutputToContain('Action must be in the container')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestAction';

        $this->artisan('make:action', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Action ['.$this->portoPath.'/Containers/'.$this->containerName.'/Actions/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Actions/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getActionContent(), file_get_contents($file));
    }

    /**
     * @return string
     */
    public function getActionContent(): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Actions;

class TestAction
{
    /**
     * Get response from tasks.
     *
     * @return void
     */
    public function run()
    {
        // action
    }
}

Class;
    }
}
