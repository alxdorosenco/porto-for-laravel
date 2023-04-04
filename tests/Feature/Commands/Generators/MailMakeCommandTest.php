<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;
use Illuminate\Console\Command;
use AlxDorosenco\PortoForLaravel\Tests\Traits\MarkdownContent;

class MailMakeCommandTest extends TestCase
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
        $name = 'TestMail';

        $this->artisan('make:mail', [
            'name' => $name
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Ship/Mails/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getMailContent($name, 'Ship\Mails'), file_get_contents($file));
    }

    /**
     * Test of the console command with container
     *
     * @return void
     */
    public function testConsoleCommandWithContainer(): void
    {
        $name = 'TestMail';

        $this->artisan('make:mail', [
            'name' => $name,
            '--container' => $this->containerName
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Mails/'.$name.'.php';

        $this->assertFileExists($file);
        $this->assertEquals($this->getMailContent($name, 'Containers\\'.$this->containerName.'\Mails'), file_get_contents($file));
    }

    /**
     * Test of the console command with types
     *
     * @dataProvider provideTypes
     * @return void
     */
    public function testConsoleCommandWithTypes(string $type): void
    {
        $name = 'Test'.(ucfirst($type)).'Mail';
        $markdown = 'MarkdownMail';

        $this->artisan('make:mail', [
            'name' => $name,
            '--container' => $this->containerName,
            '--'.$type => $type === 'markdown' ? $markdown : true
        ])->assertExitCode(0);

        $file = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Mails/'.$name.'.php';
        $markdownFile = base_path($this->portoPath).'/Containers/'.$this->containerName.'/Mails/Templates/'.$markdown.'.blade.php';

        $this->assertFileExists($file);

        if($type === 'markdown'){
            $this->assertEquals($this->getMarkdownMailContent($name, 'Containers\\'.$this->containerName.'\Mails',  $markdown), file_get_contents($file));

            $this->assertFileExists($markdownFile);
            $this->assertEquals($this->getMarkdownContent(), file_get_contents($markdownFile));
        } else {
            $this->assertEquals($this->getMailContent($name, 'Containers\\'.$this->containerName.'\Mails'), file_get_contents($file));
        }
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getMailContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use {$this->portoPathUcFirst()}\Ship\Abstracts\Mails\Mailable;
use Illuminate\Queue\SerializesModels;

class $name extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return ".'$this'."
     */
    public function build()
    {
        return ".'$this'."->view('view.name');
    }
}
";
    }
}
