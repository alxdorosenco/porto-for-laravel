<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class RequestMakeCommandTest extends TestCase
{
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
}
