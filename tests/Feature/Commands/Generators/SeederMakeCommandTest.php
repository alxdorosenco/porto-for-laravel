<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\SeedContent;

class SeederMakeCommandTest extends TestCase
{
    use SeedContent;

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $name = 'TestSeeder';

        $commandStatus = $this->artisan('make:seeder', [
            'name' => $name
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Seeders/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getSeederContent($name, 'Ship\Seeders'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $name = 'TestSeeder';

        $commandStatus = $this->artisan('make:seeder', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Seeders/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getSeederContent($name, 'Containers\\'.$this->containerName.'\Data\Seeders'), file_get_contents($file));
    }
}
