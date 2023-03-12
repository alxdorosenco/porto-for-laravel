<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ConfigMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $commandStatus = $this->artisan('make:config', [
            'name' => 'TestConfig',
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
        $commandStatus = $this->artisan('make:config', [
            'name' => 'Test1Config',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
