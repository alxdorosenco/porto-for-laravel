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
    public function testConsoleCommand()
    {
        $name = 'TestCommand';

        $commandStatus = $this->artisan('make:command', [
            'name' => 'TestCommand',
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Commands/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getConsoleCommandContent($name, 'Ship\Commands', 'command:name'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $name = 'TestCommand';

        $commandStatus = $this->artisan('make:command', [
            'name' => $name,
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

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
    public function testConsoleCommandWithTypes(string $type)
    {
        $name = 'Test2'.(ucfirst($type)).'Command';

        $commandStatus = $this->artisan('make:command', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $type === 'command' ? 'TestCommand' : true
        ]);

        $this->assertEquals(0, $commandStatus);

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
";
    }
}
