<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

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
        $commandStatus = $this->artisan('make:command', [
            'name' => 'TestCommand',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer()
    {
        $commandStatus = $this->artisan('make:command', [
            'name' => 'Test1Command',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type)
    {
        $commandStatus = $this->artisan('make:command', [
            'name' => 'Test2'.(ucfirst($type)).'Command',
            '--container' => $this->containerName,
            '--'.$type => $type === 'command' ? 'TestCommand' : true
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
