<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;

class RepositoryMakeCommandTest extends TestCase
{
    use FilesAndDirectories;

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $commandStatus = $this->artisan('make:repository', [
            'name' => 'TestRepository',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestRepository';

        $commandStatus = $this->artisan('make:repository', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Repositories/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getRepositoryContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getRepositoryContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Repositories;

class $name
{
    // repository class
}

Class;

    }
}
