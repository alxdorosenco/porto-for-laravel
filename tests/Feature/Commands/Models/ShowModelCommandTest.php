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
        $command = $this->artisan('model:show', [
            'model' => 'ModelName',
            '--container' => $this->containerName
        ]);

        if(!interface_exists('Doctrine\DBAL\Driver')){
            $command->expectsConfirmation('Inspecting database information requires the Doctrine DBAL (doctrine/dbal) package. Would you like to install it?');
            $command->assertFailed();
        } else {
            $command->assertSuccessful();
        }
    }
}
