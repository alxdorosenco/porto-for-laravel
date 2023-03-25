<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class CastMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'inbound' => ['inbound']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:cast', [
            'name' => 'TestCast',
        ])
            ->expectsOutputToContain('Cast must be in the container')
            ->assertFailed();
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
        ])
            ->expectsOutputToContain('Cast ['.$this->portoPath.'/Containers/'.$this->containerName.'/Casts/TestCast.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Casts/TestCast.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getCastContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Cast';

        $this->artisan('make:cast', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsOutputToContain('Cast ['.$this->portoPath.'/Containers/'.$this->containerName.'/Casts/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Casts/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'inbound'){
            $this->assertEquals($this->getCastInboudContent($name), file_get_contents($file));
        } else {
            $this->assertEquals($this->getCastContent($name), file_get_contents($file));
        }
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

    /**
     * @param string $name
     * @return string
     */
    private function getCastInboudContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;

class $name implements CastsInboundAttributes
{
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
