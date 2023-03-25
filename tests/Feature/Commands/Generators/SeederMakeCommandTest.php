<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class SeederMakeCommandTest extends TestCase
{
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
        ])
            ->expectsOutputToContain('Seeder ['.$this->portoPath.'/Ship/Seeders/'.$name.'.php] created successfully.')
            ->assertSuccessful();

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
        ])
            ->expectsOutputToContain('Seeder ['.$this->portoPath.'/Containers/'.$this->containerName.'/Data/Seeders/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Data/Seeders/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getSeederContent($name, 'Containers\\'.$this->containerName.'\Data\Seeders'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getSeederContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Seeders\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class $name extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}

Class;

    }
}
