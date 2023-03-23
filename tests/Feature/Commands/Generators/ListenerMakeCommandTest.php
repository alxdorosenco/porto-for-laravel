<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

class ListenerMakeCommandTest extends TestCase
{
    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'event' => ['event'],
            'force' => ['force'],
            'queued' => ['queued'],
            'queued-event' => ['queuedEvent']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:listener', [
            'name' => 'TestListener',
        ])
            ->expectsOutputToContain('Listener must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestListener';

        $this->artisan('make:listener', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Listener ['.$this->portoPath.'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getListenerDuck($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Listener';
        $eventName = 'EventListener';

        $params = [
            'name' => $name,
            '--container' => $this->containerName
        ];

        if($type === 'queuedEvent'){
            $params['--queued'] = true;
            $params['--event'] = $eventName;
        } else {
            $params['--'.$type] = $type === 'event' ? 'EventListener' : true;
        }

        $this->artisan('make:listener', $params)
            ->expectsOutputToContain('Listener ['.$this->portoPath.'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Listeners/'.$name.'.php';

        $this->assertFileExists($file);

        if($type === 'event'){
            $this->assertEquals($this->getListener($name), file_get_contents($file));
        } elseif($type === 'queued'){
            $this->assertEquals($this->getListenerQueuedDuck($name), file_get_contents($file));
        } elseif($type === 'queuedEvent'){
            $this->assertEquals($this->getListenerQueued($name), file_get_contents($file));
        } else {
            $this->assertEquals($this->getListenerDuck($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getListener(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use {{ eventNamespace }};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle({{ event }} ".'$event'."): void
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @return string
     */
    private function getListenerDuck(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object ".'$event'."): void
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @return string
     */
    private function getListenerQueued(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use {{ eventNamespace }};
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle({{ event }} ".'$event'."): void
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @return string
     */
    private function getListenerQueuedDuck(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class $name implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object ".'$event'."): void
    {
        //
    }
}
";
    }
}
