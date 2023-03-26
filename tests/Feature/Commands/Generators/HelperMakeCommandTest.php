<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class HelperMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $name = 'TestHelper';

        $this->artisan('make:helper', [
            'name' => $name
        ])
            ->expectsOutputToContain('Helper ['.$this->portoPath.'/Ship/Helpers/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Ship/Helpers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getHelperContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHelperContent(string $name): string
    {
        return <<<File
<?php

//

File;

    }
}
