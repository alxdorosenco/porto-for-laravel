<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait MarkdownContent
{
    /**
     * @return string
     */
    private function getMarkdownContent(): string
    {
        return <<<Class
@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

Class;

    }

    /**
     * @param string $name
     * @param string $namespace
     * @param string $markdown
     * @return string
     */
    private function getMarkdownMailContent(string $name, string $namespace, string $markdown): string
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
        return ".'$this'."->markdown('$markdown');
    }
}
";
    }

    /**
     * @param string $name
     * @param string $markdown
     * @return string
     */
    private function getMarkdownNotificationContent(string $name, string $markdown): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use {$this->portoPathUcFirst()}\Ship\Notifications\Messages\MailMessage;
use {$this->portoPathUcFirst()}\Ship\Notifications\Notification;

class $name extends Notification
{
    use Queueable;

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
        return (new MailMessage)->markdown('$markdown');
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
