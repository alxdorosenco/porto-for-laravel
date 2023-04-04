<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ChannelMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $commandStatus = $this->artisan('make:channel', [
            'name' => 'TestChannel',
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestChannel';

        $commandStatus = $this->artisan('make:channel', [
            'name' => 'TestChannel',
            '--container' => $this->containerName
        ]);

        $this->assertEquals(0, $commandStatus);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Broadcasting/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getChannelContent($name), file_get_contents($file));
    }

    /**
     * @param string $name
     * @return string
     */
    private function getChannelContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Broadcasting;

use {$this->portoPathUcFirst()}\Ship\Models\UserModel;

class $name
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Models\UserModel  ".'$user'."
     * @return array|bool
     */
    public function join(UserModel ".'$user'.")
    {
        //
    }
}
";
    }
}
