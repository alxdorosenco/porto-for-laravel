<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class RequestMakeCommandTest extends TestCase
{
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
            ->expectsQuestion('Please, select type of the user\'s interface', 'api')
            ->assertExitCode(0);
    }
}
