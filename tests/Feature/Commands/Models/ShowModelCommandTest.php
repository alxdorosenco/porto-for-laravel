<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Models;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ShowModelCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('model:show', [
            'model' => 'ModelName',
            '--container' => $this->containerName
        ])->assertSuccessful();
    }
}
