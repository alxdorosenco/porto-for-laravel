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
        $name = 'TestTranslation';

        $commandStatus = $this->artisan('make:translation', [
            'name' => $name
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Translations/en/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTranslationContent(), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Translation';

        $commandStatus = $this->artisan('make:translation', [
            'name' => $name,
            '--'.$type => 'en'
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Translations/en/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getTranslationContent(), file_get_contents($file));
    }

    /**
     * @return string
     */
    private function getTranslationContent(): string
    {
        return <<<File
<?php

return [
   // translation arrays
];

File;

    }
}
