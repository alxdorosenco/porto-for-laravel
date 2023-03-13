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
    public function testConsoleCommand()
    {
        $commandStatus = $this->artisan('porto:install', [
            '--path' => $this->portoPath,
            '--container' => $this->containerName,
            '--container-full' => true
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
