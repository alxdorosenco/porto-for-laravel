<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class MiddlewareMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $commandStatus = $this->artisan('make:middleware', [
            'name' => 'TestMiddleware',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $commandStatus = $this->artisan('make:middleware', [
            'name' => 'Test1Middleware',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
