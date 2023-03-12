<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class HelperMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $commandStatus = $this->artisan('make:helper', [
            'name' => 'TestHelper',
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
