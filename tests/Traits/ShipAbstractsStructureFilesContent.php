<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait ShipAbstractsStructureFilesContent
{
    /**
     * @return string
     */
    protected function contentShipAbstractsBroadcastingChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Broadcasting;

use Illuminate\Broadcasting\Channel as LaravelChannel;

abstract class Channel extends LaravelChannel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsBroadcastingPresenceChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Broadcasting;

use Illuminate\Broadcasting\PresenceChannel as LaravelPresenceChannel;

abstract class PresenceChannel extends LaravelPresenceChannel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsBroadcastingPrivateChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Broadcasting;

use Illuminate\Broadcasting\PrivateChannel as LaravelPrivateChannel;

abstract class PrivateChannel extends LaravelPrivateChannel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsCommandsConsoleCommand(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Commands;

use Illuminate\Console\Command as LaravelCommand;

abstract class ConsoleCommand extends LaravelCommand
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsComponentsComponent(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Components;

use Illuminate\View\Component as LaravelComponent;

abstract class Component extends LaravelComponent
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsControllersController(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelBaseController;

abstract class Controller extends LaravelBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsEventsEvent(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsExceptionsHandler(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as LaravelExceptionHandler;

abstract class Handler extends LaravelExceptionHandler
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsFactoriesFactory(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Factories;

use Illuminate\Database\Eloquent\Factories\Factory as LaravelFactory;

abstract class Factory extends LaravelFactory
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsJobsJob(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;

abstract class Job
{
    use Dispatchable;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsJobsJobQueued(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class JobQueued implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMailsMailable(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable as LaravelMailable;
use Illuminate\Queue\SerializesModels;

abstract class Mailable extends LaravelMailable
{
    use Queueable, SerializesModels;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMailsMailablesContent(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Mails\Mailables;

use Illuminate\Mail\Mailables\Content as LaravelContent;

abstract class Content extends LaravelContent
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMailsMailablesEnvelope(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Mails\Mailables;

use Illuminate\Mail\Mailables\Envelope as LaravelEnvelope;

abstract class Envelope extends LaravelEnvelope
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareAuthenticate(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Auth\Middleware\Authenticate as LaravelMiddleware;

abstract class Authenticate extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareEncryptCookies(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as LaravelMiddleware;

abstract class EncryptCookies extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewarePreventRequestsDuringMaintenance(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as LaravelMiddleware;

abstract class PreventRequestsDuringMaintenance extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareTrimStrings(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as LaravelMiddleware;

abstract class TrimStrings extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareTrustHosts(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Http\Middleware\TrustHosts as LaravelMiddleware;

abstract class TrustHosts extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareTrustProxies(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Http\Middleware\TrustProxies as LaravelMiddleware;

abstract class TrustProxies extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareValidateSignature(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as LaravelMiddleware;

abstract class ValidateSignature extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsMiddlewareVerifyCsrfToken(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as LaravelMiddleware;

abstract class VerifyCsrfToken extends LaravelMiddleware
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsModelsBaseModel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Models;

use Illuminate\Database\Eloquent\Model as LaravelModel;

abstract class BaseModel extends LaravelModel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsModelsUserModel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as LaravelAuthenticate;
use Illuminate\Notifications\Notifiable;

abstract class UserModel extends LaravelAuthenticate
{
    use HasFactory, Notifiable;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsModelsPivot(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Models;

use Illuminate\Database\Eloquent\Relations\Pivot as LaravelPivot;

abstract class Pivot extends LaravelPivot
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsModelsMorphPivot(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot as LaravelMorphPivot;

abstract class MorphPivot extends LaravelMorphPivot
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsModelsBuilder(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Models;

use Illuminate\Database\Eloquent\Builder as LaravelBuilder;

abstract class Builder extends LaravelBuilder
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsNotificationsNotification(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Notifications;

use Illuminate\Notifications\Notification as LaravelNotification;
use Illuminate\Bus\Queueable;

abstract class Notification extends LaravelNotification
{
    use Queueable;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsNotificationsMessagesMailMessage(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage as LaravelMailMessage;

abstract class MailMessage extends LaravelMailMessage
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsPoliciesPolicy(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsProvidersAuthServiceProvider(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as LaravelAuthServiceProvider;

abstract class AuthServiceProvider extends LaravelAuthServiceProvider
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsProvidersServiceProvider(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

abstract class ServiceProvider extends LaravelServiceProvider
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsProvidersEventServiceProvider(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;

abstract class EventServiceProvider extends LaravelEventServiceProvider
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsProvidersRouteServiceProvider(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelRouteServiceProvider;

abstract class RouteServiceProvider extends LaravelRouteServiceProvider
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsRequestsRequest(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Requests;

use Illuminate\Http\Request as LaravelRequest;

abstract class Request extends LaravelRequest
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsRequestsFormRequest(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Requests;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

abstract class FormRequest extends LaravelFormRequest
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsResponsesResponse(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Responses;

use Illuminate\Http\Response as LaravelResponse;

abstract class Response extends LaravelResponse
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsResponsesRedirectResponse(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Responses;

use Illuminate\Http\RedirectResponse as LaravelRedirectResponse;

abstract class RedirectResponse extends LaravelRedirectResponse
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsResourcesJsonResource(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Resources;

use Illuminate\Http\Resources\Json\JsonResource as LaravelJsonResource;

abstract class JsonResource extends LaravelJsonResource
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsResourcesResourceCollection(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection as LaravelResourceCollection;

abstract class ResourceCollection extends LaravelResourceCollection
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsSeedersSeeder(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Seeders;

use Illuminate\Database\Seeder as LaravelSeeder;

abstract class Seeder extends LaravelSeeder
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsTestsPhpUnitTestCase(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Tests\PhpUnit;

use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsTranslationsPotentiallyTranslatedString(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Translations;

use Illuminate\Translation\PotentiallyTranslatedString as LaravelPotentiallyTranslatedString;

abstract class PotentiallyTranslatedString extends LaravelPotentiallyTranslatedString
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipAbstractsViewsComponent(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Abstracts\Views;

use Illuminate\View\Component as LaravelComponent;

abstract class Component extends LaravelComponent
{

}

CLASS;
    }
}
