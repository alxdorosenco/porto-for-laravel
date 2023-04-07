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
    public function testConsoleCommand()
    {
        $name = 'TestHelper';

        $commandStatus = $this->artisan('make:helper', [
            'name' => $name
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Ship/Helpers/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getHelperContent(), file_get_contents($file));
    }

    /**
     * @return string
     */
    public function getHelperContent(): string
    {
        return <<<File
<?php

//

File;

    }
}
