<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Feature\Commands;

use AlxDorosenco\PortoForLaravel\Tests\TestCase;

use AlxDorosenco\PortoForLaravel\Tests\Traits\ShipAbstractsStructureFilesContent;
use AlxDorosenco\PortoForLaravel\Tests\Traits\ShipStructureFilesContent;

class PortoInstallCommandTest extends TestCase
{
    use ShipAbstractsStructureFilesContent;
    use ShipStructureFilesContent;

    /**
     * @return array[]
     */
    public function provideShip(): array
    {
        return [
            'Ship' => ['Ship'],
            'Ship.Abstracts.Broadcasting.Channel.php' => ['Ship/Abstracts/Broadcasting/Channel.php'],
            'Ship.Abstracts.Broadcasting.PresenceChannel.php' => ['Ship/Abstracts/Broadcasting/PresenceChannel.php'],
            'Ship.Abstracts.Broadcasting.PrivateChannel.php' => ['Ship/Abstracts/Broadcasting/PrivateChannel.php'],
            'Ship.Abstracts.Commands.ConsoleCommand.php' => ['Ship/Abstracts/Commands/ConsoleCommand.php'],
            'Ship.Abstracts.Controllers.Controller.php' => ['Ship/Abstracts/Controllers/Controller.php'],
            'Ship.Abstracts.Events.Event.php' => ['Ship/Abstracts/Events/Event.php'],
            'Ship.Abstracts.Exceptions.Handler.php' => ['Ship/Abstracts/Exceptions/Handler.php'],
            'Ship.Abstracts.Jobs.Job.php' => ['Ship/Abstracts/Jobs/Job.php'],
            'Ship.Abstracts.Jobs.JobQueued.php' => ['Ship/Abstracts/Jobs/JobQueued.php'],
            'Ship.Abstracts.Mails.Mailable.php' => ['Ship/Abstracts/Mails/Mailable.php'],
            'Ship.Abstracts.Middleware.Authenticate.php' => ['Ship/Abstracts/Middleware/Authenticate.php'],
            'Ship.Abstracts.Middleware.EncryptCookies.php' => ['Ship/Abstracts/Middleware/EncryptCookies.php'],
            'Ship.Abstracts.Middleware.TrimStrings.php' => ['Ship/Abstracts/Middleware/TrimStrings.php'],
            'Ship.Abstracts.Middleware.VerifyCsrfToken.php' => ['Ship/Abstracts/Middleware/VerifyCsrfToken.php'],
            'Ship.Abstracts.Models.BaseModel.php' => ['Ship/Abstracts/Models/BaseModel.php'],
            'Ship.Abstracts.Models.UserModel.php' => ['Ship/Abstracts/Models/UserModel.php'],
            'Ship.Abstracts.Models.Pivot.php' => ['Ship/Abstracts/Models/Pivot.php'],
            'Ship.Abstracts.Models.MorphPivot.php' => ['Ship/Abstracts/Models/MorphPivot.php'],
            'Ship.Abstracts.Models.Builder.php' => ['Ship/Abstracts/Models/Builder.php'],
            'Ship.Abstracts.Notifications.Notification.php' => ['Ship/Abstracts/Notifications/Notification.php'],
            'Ship.Abstracts.Notifications.Messages.MailMessage.php' => ['Ship/Abstracts/Notifications/Messages/MailMessage.php'],
            'Ship.Abstracts.Policies.Policy.php' => ['Ship/Abstracts/Policies/Policy.php'],
            'Ship.Abstracts.Providers.AuthServiceProvider.php' => ['Ship/Abstracts/Providers/AuthServiceProvider.php'],
            'Ship.Abstracts.Providers.ServiceProvider.php' => ['Ship/Abstracts/Broadcasting/PrivateChannel.php'],
            'Ship.Abstracts.Providers.EventServiceProvider.php' => ['Ship/Abstracts/Providers/EventServiceProvider.php'],
            'Ship.Abstracts.Providers.RouteServiceProvider.php' => ['Ship/Abstracts/Providers/RouteServiceProvider.php'],
            'Ship.Abstracts.Requests.Request.php' => ['Ship/Abstracts/Requests/Request.php'],
            'Ship.Abstracts.Requests.FormRequest.php' => ['Ship/Abstracts/Requests/FormRequest.php'],
            'Ship.Abstracts.Responses.Response.php' => ['Ship/Abstracts/Responses/Response.php'],
            'Ship.Abstracts.Responses.RedirectResponse.php' => ['Ship/Abstracts/Responses/RedirectResponse.php'],
            'Ship.Abstracts.Resources.ResourceCollection.php' => ['Ship/Abstracts/Resources/ResourceCollection.php'],
            'Ship.Abstracts.Seeders.Seeder.php' => ['Ship/Abstracts/Seeders/Seeder.php'],
            'Ship.Abstracts.Tests.PhpUnit.TestCase.php' => ['Ship/Abstracts/Tests/PhpUnit/TestCase.php'],
            'Ship.Broadcasting.Channel.php' => ['Ship/Broadcasting/Channel.php'],
            'Ship.Broadcasting.PresenceChannel.php' => ['Ship/Broadcasting/PresenceChannel.php'],
            'Ship.Broadcasting.PrivateChannel.php' => ['Ship/Broadcasting/PrivateChannel.php'],
            'Ship.Commands' => ['Ship/Commands'],
            'Ship.Configs' => ['Ship/Configs'],
            'Ship.Controllers.Controller.php' => ['Ship/Controllers/Controller.php'],
            'Ship.Events.Event.php' => ['Ship/Events/Event.php'],
            'Ship.Exceptions.Handler.php' => ['Ship/Exceptions/Handler.php'],
            'Ship.Helpers' => ['Ship/Helpers'],
            'Ship.Kernels.ConsoleKernel.php' => ['Ship/Kernels/ConsoleKernel.php'],
            'Ship.Kernels.HttpKernel.php' => ['Ship/Kernels/HttpKernel.php'],
            'Ship.Middleware.EncryptCookies.php' => ['Ship/Middleware/EncryptCookies.php'],
            'Ship.Middleware.RedirectIfAuthenticated.php' => ['Ship/Middleware/RedirectIfAuthenticated.php'],
            'Ship.Middleware.TrimStrings.php' => ['Ship/Middleware/TrimStrings.php'],
            'Ship.Middleware.TrustProxies.php' => ['Ship/Middleware/TrustProxies.php'],
            'Ship.Middleware.VerifyCsrfToken.php' => ['Ship/Middleware/VerifyCsrfToken.php'],
            'Ship.Migrations' => ['Ship/Migrations'],
            'Ship.Models.Model.php' => ['Ship/Models/Model.php'],
            'Ship.Models.UserModel.php' => ['Ship/Models/UserModel.php'],
            'Ship.Models.Pivot.php' => ['Ship/Models/Pivot.php'],
            'Ship.Models.MorphPivot.php' => ['Ship/Models/MorphPivot.php'],
            'Ship.Models.Builder.php' => ['Ship/Models/Builder.php'],
            'Ship.Notifications.Notification.php' => ['Ship/Notifications/Notification.php'],
            'Ship.Notifications.Messages/MailMessage.php' => ['Ship/Notifications/Messages/MailMessage.php'],
            'Ship.Policies.Policy.php' => ['Ship/Policies/Policy.php'],
            'Ship.Providers.AuthServiceProvider.php' => ['Ship/Providers/AuthServiceProvider.php'],
            'Ship.Providers.BroadcastServiceProvider.php' => ['Ship/Providers/BroadcastServiceProvider.php'],
            'Ship.Providers.EventServiceProvider.php' => ['Ship/Providers/EventServiceProvider.php'],
            'Ship.Providers.RouteServiceProvider.php' => ['Ship/Providers/RouteServiceProvider.php'],
            'Ship.Requests.Request.php' => ['Ship/Requests/Request.php'],
            'Ship.Requests.FormRequest.php' => ['Ship/Requests/FormRequest.php'],
            'Ship.Responses.Response.php' => ['Ship/Responses/Response.php'],
            'Ship.Responses.RedirectResponse.php' => ['Ship/Responses/RedirectResponse.php'],
            'Ship.Resources.JsonResource.php' => ['Ship/Resources/JsonResource.php'],
            'Ship.Resources.ResourceCollection.php' => ['Ship/Resources/ResourceCollection.php'],
            'Ship.Seeders' => ['Ship/Seeders'],
            'Ship.Tests.TestCase.php' => ['Ship/Tests/TestCase.php'],
            'Ship.Traits.CreatesApplication.php' => ['Ship/Traits/CreatesApplication.php'],
            'Ship.Translations' => ['Ship/Translations'],
            'Containers' => ['Containers']
        ];
    }

    /**
     * Test of the console command
     *
     * @return void
     */
    public function testConsoleCommand()
    {
        $commandStatus = $this->artisan('porto:install', [
            '--path' => $this->portoPath,
            '--container' => $this->containerName,
            '--container-full' => true
        ]);

        $this->assertEquals(0, $commandStatus);
    }

    /**
     * @param string $param
     *
     * @dataProvider provideShip
     * @return void
     */
    public function testExistenceOfTheCreatedShipFilesAndDirectories(string $param)
    {
        $path = base_path($this->portoPath).'/'.$param;

        if(stripos($param, '.php')){
            $this->assertFileExists($path);

            $content = file_get_contents($path);

            $methodName = 'content'.str_replace(['/', '.php'], ['', ''], $param);
            $this->assertEquals($this->$methodName(), $content);
        } else {
            $this->assertDirectoryExists($path);
        }
    }
}
