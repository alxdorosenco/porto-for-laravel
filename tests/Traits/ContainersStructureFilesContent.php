<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait ContainersStructureFilesContent
{
    /**
     * @return string
     */
    protected function contentContainersLoadersAliasesLoader(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$name\Loaders;

class AliasesLoader
{
    /**
     * @var array
     */
    public ".'$aliases'." = [];
}
";
    }

    /**
     * @return string
     */
    protected function contentContainersLoadersProvidersLoader(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$name\Loaders;

class ProvidersLoader
{
    /**
     * @var array
     */
    public ".'$providers'." = [];
}
";
    }

    /**
     * @return string
     */
    protected function contentContainersLoadersMiddlewareLoader(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$name\Loaders;

class MiddlewareLoader
{
    /**
     * @var array
     */
    public ".'$middleware'." = [];

    /**
     * @var array
     */
    public ".'$middlewareGroups'." = [];

    /**
     * @var array
     */
    public ".'$routeMiddleware'." = [];

    /**
     * @var array
     */
    public ".'$middlewarePriority'." = [];
}
";
    }

    /**
     * @return string
     */
    protected function contentContainersUIWEBRoutesHome(string $name): string
    {
        return <<<CLASS
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', '\\{$this->portoPathUcFirst()}\Containers\\$name\UI\WEB\Controllers\HomeController@home')->name('home');

CLASS;
    }

    /**
     * @return string
     */
    protected function contentContainersUIWEBControllersHomeController(string $name): string
    {
        $viewContainerName = strtolower(str_replace('/', '@', $name));

        return <<<CLASS
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$name\UI\WEB\Controllers;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function home(): View|Factory|Application
    {
        return view('{$viewContainerName}::home');
    }
}

CLASS;
    }

    /**
     * @return string
     */
    protected function contentContainersUIWEBViewsHome(string $name): string
    {
        return <<<CLASS
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home page</title>
</head>
<body>
    <h2>You're welcome!!!</h2>
</body>
</html>

CLASS;
    }

    /**
     * @return string
     */
    protected function contentContainersUIWEBTestsFunctionalExampleTest(string $name): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$name\UI\WEB\Tests\Functional;

use {$this->portoPathUcFirst()}\Ship\Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        ".'$response'." = ".'$this'."->get('/');

        ".'$response'."->assertStatus(200);
    }
}
";
    }
}
