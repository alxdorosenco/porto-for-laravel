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
    public function testConsoleCommand(): void
    {
        $name = 'TestHelper';

        $this->artisan('make:helper', [
            'name' => $name
        ])->assertExitCode(Command::SUCCESS);

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
