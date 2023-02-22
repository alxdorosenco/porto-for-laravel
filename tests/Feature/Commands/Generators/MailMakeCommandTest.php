<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

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
    public function testConsoleCommand(): void
    {
        $this->artisan('make:mail', [
            'name' => 'TestMail',
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $this->artisan('make:mail', [
            'name' => 'Test1Mail',
            '--container' => $this->containerName
        ])->assertSuccessful();
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $typeValue = true;

        if($type === 'markdown'){
            $typeValue = 'MarkdownMail';
        }

        $this->artisan('make:mail', [
            'name' => 'Test2'.(ucfirst($type)).'Mail',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ])->assertSuccessful();
    }
}
