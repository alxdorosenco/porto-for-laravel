<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ContractMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:contract', [
            'name' => 'TestContract',
        ])
            ->expectsOutputToContain('Contract must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestContract';

        $this->artisan('make:contract', [
            'name' => 'TestContract',
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Contract ['.$this->portoPath.'/Containers/'.$this->containerName.'/Contracts/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Contracts/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getContractContent(), file_get_contents($file));
    }

    /**
     * @return string
     */
    private function getContractContent(): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Contracts;

class TestContract
{
    // contract class
}

Class;
    }
}
