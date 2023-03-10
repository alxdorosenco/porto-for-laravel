<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ExceptionMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'render' => ['render'],
            'report' => ['report']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:exception', [
            'name' => 'TestException',
        ])->assertExitCode(Command::SUCCESS);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:exception', [
            'name' => 'Test1Exception',
            '--container' => $this->containerName
        ])->assertExitCode(Command::SUCCESS);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $this->artisan('make:exception', [
            'name' => 'Test2'.(ucfirst($type)).'Exception',
            '--container' => $this->containerName,
            '--'.$type => true
        ])->assertExitCode(Command::SUCCESS);
    }
}
