<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ConsoleMakeCommand extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
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
        ])
            ->expectsOutputToContain('Console command ['.$this->portoPath.'/Ship/Commands/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Ship/Commands/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConsoleCommandContent($name, 'Ship\Commands', 'app:test-command'), file_get_contents($file));
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
        ])
            ->expectsOutputToContain('Console command ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/CLI/Commands/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/CLI/Commands/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConsoleCommandContent($name, 'Containers\\'.$this->containerName.'\UI\CLI\Commands', 'app:test-command'), file_get_contents($file));
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
        ])
            ->expectsOutputToContain('Console command ['.$this->portoPath.'/Containers/'.$this->containerName.'/UI/CLI/Commands/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/CLI/Commands/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConsoleCommandContent($name, 'Containers\\'.$this->containerName.'\UI\CLI\Commands', $type === 'command' ? 'TestCommand' : 'app:test2-'.$type.'-command'), file_get_contents($file));
    }

    /**
     * @param string $name
     * @param string $namespace
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
        return static::SUCCESS;
    }
}
";
    }
}
