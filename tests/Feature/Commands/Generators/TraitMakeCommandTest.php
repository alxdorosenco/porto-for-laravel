<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class TraitMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'test' => ['test']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:trait', [
            'name' => 'TestTrait',
        ])->assertExitCode(Command::FAILURE);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestTrait';

        $this->artisan('make:trait', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(Command::SUCCESS);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Traits/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTraitContent($name, 'Containers\\'.$this->containerName.'\Traits'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Trait';

        $this->artisan('make:trait', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertExitCode(Command::SUCCESS);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Tests/Traits/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTraitContent($name, 'Containers\\'.$this->containerName.'\Tests\Traits'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getTraitContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

trait $name
{
    //
}

Class;
    }
}
