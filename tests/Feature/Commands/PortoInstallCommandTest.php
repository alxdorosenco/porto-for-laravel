<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class PortoInstallCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('porto:install', [
            '--container' => $this->containerName,
            '--container-full' => true
        ])
            ->expectsQuestion('Do you wish to install porto structure in your '.$this->portoPath.'/ directory?', 'Yes')
            ->assertExitCode(0);
    }
}
