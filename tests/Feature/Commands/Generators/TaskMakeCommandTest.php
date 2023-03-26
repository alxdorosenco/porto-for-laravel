<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class TaskMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:task', [
            'name' => 'TestTask',
        ])
            ->expectsOutputToContain('Task must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestTask';

        $this->artisan('make:task', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Task ['.$this->portoPath.'/Containers/'.$this->containerName.'/Tasks/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Tasks/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTaskContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getTaskContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Tasks;

class $name
{
    /**
     * Get response from repository.
     *
     * @return void
     */
    public function run()
    {
        // task
    }
}

Class;

    }
}
