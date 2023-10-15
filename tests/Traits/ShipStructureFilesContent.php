<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait ShipStructureFilesContent
{
    /**
     * @return string
     */
    protected function contentShipBroadcastingChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Broadcasting;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Broadcasting\Channel as AbstractsChannel;

class Channel extends AbstractsChannel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipBroadcastingPresenceChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Broadcasting;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Broadcasting\PresenceChannel as AbstractsPresenceChannel;

class PresenceChannel extends AbstractsPresenceChannel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipBroadcastingPrivateChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Broadcasting;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Broadcasting\PrivateChannel as AbstractsPrivateChannel;

class PrivateChannel extends AbstractsPrivateChannel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipControllersController(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Controllers;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Controllers\Controller as AbstractBaseController;

class Controller extends AbstractBaseController
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipEventsEvent(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Events;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Events\Event as AbstractEvent;

class Event extends AbstractEvent
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipExceptionsHandler(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Exceptions;

use Exception;
use {$this->portoPathUcFirst()}\Ship\Abstracts\Exceptions\Handler as AbstractHandler;

class Handler extends AbstractHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected ".'$dontReport'." = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected ".'$dontFlash'." = [
        'password',
        'password_confirmation'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  ".'$exception'."
     * @return void
     */
    public function report(Exception ".'$exception'.")
    {
        parent::report(".'$exception'.");
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  ".'$request'."
     * @param  \Exception  ".'$exception'."
     * @return \Illuminate\Http\Response
     */
    public function render(".'$request'.", Exception ".'$exception'.")
    {
        return parent::render(".'$request'.", ".'$exception'.");
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipKernelsConsoleKernel(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Kernels;

use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleKernel as TConsoleKernel;
use AlxDorosenco\PortoForLaravel\Traits\FilesAndDirectories;
use AlxDorosenco\PortoForLaravel\Loaders\CommandsLoader;
use AlxDorosenco\PortoForLaravel\Loaders\RoutesLoader;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as LaravelConsoleKernel;

class ConsoleKernel extends LaravelConsoleKernel
{
    use FilesAndDirectories;
    use TConsoleKernel;
    use CommandsLoader;
    use RoutesLoader;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  ".'$schedule'."
     * @return void
     */
    protected function schedule(Schedule ".'$schedule'.")
    {
        // ".'$schedule'."->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        ".'$this->loadCommandsForConsoleKernel();'."
        ".'$this->loadRoutesForConsoleKernel();'."
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipKernelsHttpKernel(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Kernels;

use Illuminate\Foundation\Http\Kernel as LaravelHttpKernel;

class HttpKernel extends LaravelHttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected ".'$middleware'." = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \\{$this->portoPathUcFirst()}\Ship\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Ship\Middleware\TrustProxies::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected ".'$middlewareGroups'." = [
        'web' => [
            \\{$this->portoPathUcFirst()}\Ship\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \\{$this->portoPathUcFirst()}\Ship\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings'
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected ".'$routeMiddleware'." = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \\{$this->portoPathUcFirst()}\Ship\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMailsMailablesContent(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Mails\Mailables;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Mails\Mailables\Content as AbstractContent;

class Content extends AbstractContent
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipMailsMailablesEnvelope(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Mails\Mailables;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Mails\Mailables\Envelope as AbstractEnvelope;

class Envelope extends AbstractEnvelope
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareAuthenticate(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\Authenticate as AbstractMiddleware;

class Authenticate extends AbstractMiddleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  ".'$request'."
     * @return string|null
     */
    protected function redirectTo(".'$request'.")
    {
        if (! ".'$request'."->expectsJson()) {
            return route('login');
        }
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareEncryptCookies(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\EncryptCookies as AbstractMiddleware;

class EncryptCookies extends AbstractMiddleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected ".'$except'." = [
        //
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewarePreventRequestsDuringMaintenance(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\PreventRequestsDuringMaintenance as AbstractMiddleware;

class PreventRequestsDuringMaintenance extends AbstractMiddleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected ".'$except'." = [
        //
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareRedirectIfAuthenticated(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  ".'$request'."
     * @param  \Closure  ".'$next'."
     * @param  string|null  ".'$guard'."
     * @return mixed
     */
    public function handle(".'$request'.", Closure ".'$next'.", ".'$guard'." = null)
    {
        if (Auth::guard(".'$guard'.")->check()) {
            return redirect('/home');
        }

        return ".'$next($request)'.";
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareTrimStrings(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\TrimStrings as AbstractMiddleware;

class TrimStrings extends AbstractMiddleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected ".'$except'." = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareTrustHosts(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\TrustHosts as AbstractMiddleware;

class TrustHosts extends AbstractMiddleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<int, string|null>
     */
    public function hosts()
    {
        return [
            ".'$this->allSubdomainsOfApplicationUrl()'.",
        ];
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareTrustProxies(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\TrustProxies as AbstractMiddleware;
use Illuminate\Http\Request;

class TrustProxies extends AbstractMiddleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected ".'$proxies'.";

    /**
     * The current proxy header mappings.
     *
     * @var int
     */
    protected ".'$headers'." = [
        Request::HEADER_FORWARDED => 'FORWARDED',
        Request::HEADER_X_FORWARDED_FOR => 'X_FORWARDED_FOR',
        Request::HEADER_X_FORWARDED_HOST => 'X_FORWARDED_HOST',
        Request::HEADER_X_FORWARDED_PORT => 'X_FORWARDED_PORT',
        Request::HEADER_X_FORWARDED_PROTO => 'X_FORWARDED_PROTO',
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareValidateSignature(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\ValidateSignature as AbstractMiddleware;

class ValidateSignature extends AbstractMiddleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected ".'$except'." = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipMiddlewareVerifyCsrfToken(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Middleware;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Middleware\VerifyCsrfToken as AbstractMiddleware;

class VerifyCsrfToken extends AbstractMiddleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected ".'$except'." = [
        //
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipModelsModel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Models;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Models\BaseModel as AbstractBaseModel;

class Model extends AbstractBaseModel
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipModelsUserModel(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Models;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Models\UserModel as AbstractUserModel;

class UserModel extends AbstractUserModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected ".'$fillable'." = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected ".'$hidden'." = [
        'password', 'remember_token',
    ];
}
";
    }

    /**
     * @return string
     */
    protected function contentShipModelsPivot(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Models;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Models\Pivot as AbstractPivot;

class Pivot extends AbstractPivot
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipModelsMorphPivot(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Models;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Models\MorphPivot as AbstractMorphPivot;

class MorphPivot extends AbstractMorphPivot
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipModelsBuilder(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Models;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Models\Builder as AbstractBuilder;

class Builder extends AbstractBuilder
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipModelsScope(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Models;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder ".'$builder'."
     * @param Model ".'$model'."
     * @return void
     */
    public function apply(Builder ".'$builder'.", Model ".'$model'.");
}
";
    }

    /**
     * @return string
     */
    protected function contentShipNotificationsNotification(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Notifications;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Notifications\Notification as AbstractsNotification;

class Notification extends AbstractsNotification
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipNotificationsMessagesMailMessage(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Notifications\Messages;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Notifications\Messages\MailMessage as AbstractsMailMessage;

class MailMessage extends AbstractsMailMessage
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipPoliciesPolicy(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Policies;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Policies\Policy as AbstractsPolicy;

class Policy extends AbstractsPolicy
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipProvidersAuthServiceProvider(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Providers;

use Illuminate\Support\Facades\Gate;
use {$this->portoPathUcFirst()}\Ship\Abstracts\Providers\AuthServiceProvider as AbstractAuthServiceProvider;

class AuthServiceProvider extends AbstractAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected ".'$policies'." = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        ".'$this->registerPolicies()'.";

        //
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipProvidersBroadcastServiceProvider(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Providers;

use Illuminate\Support\Facades\Broadcast;
use {$this->portoPathUcFirst()}\Ship\Abstracts\Providers\ServiceProvider as AbstractServiceProvider;

class BroadcastServiceProvider extends AbstractServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipProvidersEventServiceProvider(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Providers;

use Illuminate\Support\Facades\Event;
use {$this->portoPathUcFirst()}\Ship\Abstracts\Providers\EventServiceProvider as AbstractEventServiceProvider;

class EventServiceProvider extends AbstractEventServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected ".'$listen'." = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipProvidersRouteServiceProvider(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Providers;

use Illuminate\Support\Facades\Route;
use {$this->portoPathUcFirst()}\Ship\Abstracts\Providers\RouteServiceProvider as AbstractRouteServiceProvider;

class RouteServiceProvider extends AbstractRouteServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }
}
";
    }

    /**
     * @return string
     */
    protected function contentShipRequestsRequest(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Requests;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Requests\Request as AbstractRequest;

class Request extends AbstractRequest
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipRequestsFormRequest(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Requests;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Requests\FormRequest as AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipResponsesResponse(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Responses;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Responses\Response as AbstractResponse;

class Response extends AbstractResponse
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipResponsesRedirectResponse(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Responses;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Responses\RedirectResponse as AbstractRedirectResponse;

class RedirectResponse extends AbstractRedirectResponse
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipResourcesJsonResource(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Resources;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Resources\JsonResource as AbstractJsonResource;

class JsonResource extends AbstractJsonResource
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipResourcesResourceCollection(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Ship\Resources;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Resources\ResourceCollection as AbstractResourceCollection;

class ResourceCollection extends AbstractResourceCollection
{

}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentShipTestsTestCase(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Tests;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use {$this->portoPathUcFirst()}\Ship\Traits\CreatesApplication;

abstract class TestCase extends AbstractTestCase
{
    use CreatesApplication;
}
";
    }

    /**
     * @return string
     */
    protected function contentShipTraitsCreatesApplication(): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Ship\Traits;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        ".'$app'." = require __DIR__.'/../../../bootstrap/app.php';

        ".'$app'."->make(Kernel::class)->bootstrap();

        return ".'$app'.";
    }
}
";
    }
}
