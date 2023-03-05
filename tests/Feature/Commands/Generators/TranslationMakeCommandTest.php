<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class TranslationMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'lang'  => ['lang']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:translation', [
            'name' => 'TestTranslation',
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

        if($type === 'lang'){
            $typeValue = 'en';
        }

        $testCommand = $this->artisan('make:translation', [
            'name' => 'Test2'.(ucfirst($type)).'Translation',
            '--container' => $this->containerName,
            '--'.$type => $typeValue
        ]);

        $testCommand->assertSuccessful();
    }
}
