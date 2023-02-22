<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:request', [
            'name' => 'TestRequest',
        ])->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:request', [
            'name' => 'Test1Request',
            '--container' => $this->containerName
        ])
            ->expectsChoice('Please, select type of the user\'s interface', 'api', ['api' => 'api', 'web' => 'web'])
            ->assertSuccessful();
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $this->artisan('make:request', [
            'name' => 'Test2'.(ucfirst($type)).'Request',
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsChoice('Please, select type of the user\'s interface', 'web', ['api' => 'api', 'web' => 'web'])
            ->assertSuccessful();
    }
}
