<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class EventMakeCommandTest extends TestCase
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
        $this->artisan('make:event', [
            'name' => 'TestEvent',
        ])
            ->expectsOutputToContain('Event must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestEvent';

        $this->artisan('make:event', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Event ['.$this->portoPath.'/Containers/'.$this->containerName.'/Events/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Events/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getEventContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test2'.(ucfirst($type)).'Event';

        $this->artisan('make:event', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => true
        ])
            ->expectsOutputToContain('Event ['.$this->portoPath.'/Containers/'.$this->containerName.'/Events/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Events/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getEventContent($name), file_get_contents($file));
    }

    /**
     * @return string
     */
    private function getEventContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Events;

use {$this->portoPathUcFirst()}\Ship\Broadcasting\Channel;
use {$this->portoPathUcFirst()}\Ship\Broadcasting\PresenceChannel;
use {$this->portoPathUcFirst()}\Ship\Broadcasting\PrivateChannel;
use {$this->portoPathUcFirst()}\Ship\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class $name extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

Class;
    }
}
