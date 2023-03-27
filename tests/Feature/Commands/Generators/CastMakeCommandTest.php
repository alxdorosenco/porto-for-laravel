<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class CastMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:cast', [
            'name' => 'TestCast',
        ])->assertExitCode(Command::FAILURE);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestCast';

        $this->artisan('make:cast', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(Command::SUCCESS);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Casts/TestCast.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getCastContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getCastContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class $name implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Models\Model  ".'$model'."
     * @param  string  ".'$key'."
     * @param  mixed  ".'$value'."
     * @param  array  ".'$attributes'."
     * @return mixed
     */
    public function get(".'$model'.", string ".'$key'.", ".'$value'.", array ".'$attributes'.")
    {
        return ".'$value'.";
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Models\Model  ".'$model'."
     * @param  string  ".'$key'."
     * @param  mixed  ".'$value'."
     * @param  array  ".'$attributes'."
     * @return mixed
     */
    public function set(".'$model'.", string ".'$key'.", ".'$value'.", array ".'$attributes'.")
    {
        return ".'$value'.";
    }
}
";
    }
}
