<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class TestMakeCommandTest extends TestCase
{
    /**
     * @return \string[][]
     */
    public function provideTestUi(): array
    {
        return [
            'api' => ['api'],
            'web' => ['web'],
            'cli' => ['cli']
        ];
    }

    /**
     * Test of the console command with unit
     *
     * @return void
     */
    public function testConsoleCommandWithUnit(): void
    {
        $this->artisan('make:test', [
            'name' => 'TestUnit',
            '--unit' => true,
            '--container' => $this->containerName
        ])->assertExitCode(Command::SUCCESS);
    }

    /**
     * Test of the console command
     *
     * @dataProvider provideTestUi
     * @return void
     */
    public function testConsoleCommandWithFunctional(string $ui): void
    {
        $this->artisan('make:test', [
            'name' => 'Name',
            '--container' => $this->containerName
        ])
            ->expectsChoice('Please, select type of the user\'s interface', $ui, ['api' => 'api', 'web' => 'web', 'cli' => 'cli'])
            ->assertExitCode(Command::SUCCESS);
    }
}
