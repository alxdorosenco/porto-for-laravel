<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;
use AlxDorosenco\PortoForLaravel\Tests\Traits\SeedContent;

class SeederMakeCommandTest extends TestCase
{
    use SeedContent;

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestSeeder';

        $this->artisan('make:seeder', [
            'name' => $name
        ])->assertExitCode(Command::SUCCESS);

        $file = base_path($this->portoPath).'/Ship/Seeders/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getSeederContent($name, 'Ship\Seeders'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestSeeder';

        $this->artisan('make:seeder', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(Command::SUCCESS);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Seeders/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getSeederContent($name, 'Containers\\'.$this->containerName.'\Data\Seeders'), file_get_contents($file));
    }
}
