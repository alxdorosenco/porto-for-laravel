<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ChannelMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:channel', [
            'name' => 'TestChannel',
        ])
            ->expectsOutputToContain('Channel must be in the container')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestChannel';

        $this->artisan('make:channel', [
            'name' => 'TestChannel',
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Channel ['.$this->portoPath.'/Containers/'.$this->containerName.'/Broadcasting/TestChannel.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Broadcasting/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getChannelContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Channel';

        $this->artisan('make:channel', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsOutputToContain('Channel ['.$this->portoPath.'/Containers/'.$this->containerName.'/Broadcasting/'.$name.'.php] created successfully.')
            ->assertSuccessful();

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
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(UserModel ".'$user'."): array|bool
    {
        //
    }
}
";
    }
}
