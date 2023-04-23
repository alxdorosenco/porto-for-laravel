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
<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

Class;

    }

    /**
     * @param string $name
     * @param string $namespace
     * @param string $markdown
     * @return string
     */
    private function getMarkdownMailContent(string $name, string $namespace, string $subject, string $markdown): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Mails\Mailable;
use {$this->portoPathUcFirst()}\Ship\Mails\Mailable\Content;
use {$this->portoPathUcFirst()}\Ship\Mails\Mailable\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class $name extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '$subject',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: '$markdown',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

Class;

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

use {$this->portoPathUcFirst()}\Ship\Notifications\Messages\MailMessage;
use {$this->portoPathUcFirst()}\Ship\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class $name extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object ".'$notifiable'."): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object ".'$notifiable'."): MailMessage
    {
        return (new MailMessage)->markdown('$markdown');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object ".'$notifiable'."): array
    {
        return [
            //
        ];
    }
}
";

    }
}
