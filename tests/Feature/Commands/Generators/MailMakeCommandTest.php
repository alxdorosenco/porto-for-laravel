<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class MailMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'markdown' => ['markdown']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $commandStatus = $this->artisan('make:mail', [
            'name' => 'TestMail',
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
        $commandStatus = $this->artisan('make:mail', [
            'name' => 'Test1Mail',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type)
    {
        $typeValue = true;

        if($type === 'markdown'){
            $typeValue = 'MarkdownMail';
        }

        $commandStatus = $this->artisan('make:mail', [
            'name' => 'Test2'.(ucfirst($type)).'Mail',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ]);

        $this->assertEquals(0, $commandStatus);
    }
}
