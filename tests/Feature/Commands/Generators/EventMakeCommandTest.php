<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;

class EventMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:event', [
            'name' => 'TestEvent',
        ])->assertExitCode(Command::FAILURE);
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
        ])->assertExitCode(Command::SUCCESS);

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
