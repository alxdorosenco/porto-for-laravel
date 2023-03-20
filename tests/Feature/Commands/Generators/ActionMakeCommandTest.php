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
        $this->artisan('make:action', [
            'name' => 'TestAction',
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Action ['.$this->portoPath.'/Containers/'.$this->containerName.'/Actions/TestAction.php] created successfully.')
            ->assertSuccessful();
    }

    public function testExistenceOfAction(): void
    {
        $this->assertFileExists(base_path($this->portoPath).'/Containers/'.$this->containerName.'/Actions/TestAction.php');
    }

    public function testEqualsOfActionContent(): void
    {
        $fileContent = file_get_contents(base_path($this->portoPath).'/Containers/'.$this->containerName.'/Actions/TestAction.php');
        $content = <<<Class
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
        $this->assertEquals($content, $fileContent);
    }
}
