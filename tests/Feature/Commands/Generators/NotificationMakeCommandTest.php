<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use AlxDorosenco\PortoForLaravel\Tests\Traits\MarkdownContent;

class NotificationMakeCommandTest extends TestCase
{
    use MarkdownContent;

    /**
     * @return array[]
     */
    public function provideTypes(): array
    {
        return [
            'force' => ['force'],
            'markdown' => ['markdown']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('make:notification', [
            'name' => 'TestNotification',
        ])
            ->expectsOutputToContain('Notification must be in the container.')
            ->assertFailed();
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestNotification';

        $this->artisan('make:notification', [
            'name' => $name,
            '--container' => $this->containerName
        ])
            ->expectsOutputToContain('Notification ['.$this->portoPath.'/Containers/'.$this->containerName.'/Notifications/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Notifications/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getNotificationContent($name), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Notification';
        $markdown = 'MarkdownNotification';

        $this->artisan('make:notification', [
            'name' => 'Test'.(ucfirst($type)).'Notification',
            '--container' => $this->containerName,
            '--'.$type => $type === 'markdown' ? $markdown : true
        ])
            ->expectsOutputToContain('Notification ['.$this->portoPath.'/Containers/'.$this->containerName.'/Notifications/'.$name.'.php] created successfully.')
            ->assertSuccessful();

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Notifications/'.$name.'.php';
        $markdownFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/UI/WEB/Views/'.$markdown.'.blade.php';

        $this->assertFileExists($file);

        if($type === 'markdown'){
            $this->assertEquals($this->getMarkdownNotificationContent($name,  $markdown), file_get_contents($file));

            $this->assertFileExists($markdownFile);
            $this->assertEquals($this->getMarkdownContent(), file_get_contents($markdownFile));
        } else {
            $this->assertEquals($this->getNotificationContent($name), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function getNotificationContent(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Notifications;

use {$this->portoPathUcFirst()}\Ship\Notifications\Messages\MailMessage;
use {$this->portoPathUcFirst()}\Ship\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class $name extends Notification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  ".'$notifiable'."
     * @return array
     */
    public function via(".'$notifiable'.")
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  ".'$notifiable'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Notifications\Messages\MailMessage
     */
    public function toMail(".'$notifiable'.")
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  ".'$notifiable'."
     * @return array
     */
    public function toArray(".'$notifiable'.")
    {
        return [
            //
        ];
    }
}
";
    }
}
