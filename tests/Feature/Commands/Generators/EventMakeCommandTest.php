<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class EventMakeCommandTest extends TestCase
{
    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $commandStatus = $this->artisan('make:event', [
            'name' => 'TestEvent',
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
        $name = 'TestEvent';

        $this->artisan('make:event', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(0);

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
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class $name
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

Class;
    }
}
