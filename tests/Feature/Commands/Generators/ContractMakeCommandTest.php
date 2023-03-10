<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class ContractMakeCommandTest extends TestCase
{
    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:contract', [
            'name' => 'Test1Contract',
            '--container' => $this->containerName
        ])->assertExitCode(0);
    }
}
