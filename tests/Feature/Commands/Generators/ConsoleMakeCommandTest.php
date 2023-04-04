<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ConsoleMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'command' => ['command']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestCommand';

        $this->artisan('make:command', [
            'name' => 'TestCommand',
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Ship/Commands/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConsoleCommandContent($name, 'Ship\Commands', 'command:name'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestCommand';

        $this->artisan('make:command', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/CLI/Commands/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConsoleCommandContent($name, 'Containers\\'.$this->containerName.'\UI\CLI\Commands', 'command:name'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test2'.(ucfirst($type)).'Command';

        $this->artisan('make:command', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $type === 'command' ? 'TestCommand' : true
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/CLI/Commands/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'command'){
            $this->assertEquals($this->getConsoleCommandContent($name, 'Containers\\'.$this->containerName.'\UI\CLI\Commands', 'TestCommand'), file_get_contents($file));
        } else {
            $this->assertEquals($this->getConsoleCommandContent($name, 'Containers\\'.$this->containerName.'\UI\CLI\Commands', 'command:name'), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @param string $namespace
     * @param string $command
     * @return string
     */
    private function getConsoleCommandContent(string $name, string $namespace, string $command): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Commands\ConsoleCommand as AbstractConsoleCommand;

class $name extends AbstractConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected ".'$signature'." = '$command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected ".'$description'." = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
";
    }
}
