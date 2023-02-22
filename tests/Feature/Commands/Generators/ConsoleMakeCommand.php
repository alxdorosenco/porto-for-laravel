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
        $this->artisan('make:command', [
            'name' => 'TestCommand',
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:command', [
            'name' => 'Test1Command',
            '--container' => $this->containerName
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $this->artisan('make:command', [
            'name' => 'Test2'.(ucfirst($type)).'Command',
            '--container' => $this->containerName,
            '--'.$type => $type === 'command' ? 'TestCommand' : true
        ])->assertSuccessful();
    }
}
