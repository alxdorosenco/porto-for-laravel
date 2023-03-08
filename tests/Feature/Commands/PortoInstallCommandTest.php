<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

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
            ->expectsConfirmation('Do you wish to install porto structure in your '.$this->portoPath.'/ directory?', 'Yes')
            ->assertSuccessful();
    }
}
