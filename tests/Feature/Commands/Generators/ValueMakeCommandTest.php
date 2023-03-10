<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ValueMakeCommandTest extends TestCase
{
    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:value', [
            'name' => 'Test1Value',
            '--container' => $this->containerName
        ])->assertExitCode(0);
    }
}
