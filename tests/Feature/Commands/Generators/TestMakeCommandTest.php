<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

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
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with pest
     *
     * @dataProvider provideTestUi
     * @return void
     */
    public function testConsoleCommandWithPest(string $ui): void
    {
        $this->artisan('make:test', [
            'name' => 'TestPest',
            '--pest' => true,
            '--container' => $this->containerName
        ])
            ->expectsChoice('Please, select type of the user\'s interface', $ui, ['api' => 'api', 'web' => 'web', 'cli' => 'cli'])
            ->assertSuccessful();
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
            ->assertSuccessful();
    }
}
