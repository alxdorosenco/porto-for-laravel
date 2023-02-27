# Porto for Laravel

This is a package who gives flexible way to build a structure of the Porto (Software Architectural Pattern) in your Laravel project.
You should no longer to migrate a lot of files and folders handle. 

This package will do the job for you in some clicks. 

- [Introduction](#Introduction)
- [How to install?](#HowToInstall?)
- [Ship structure](#ShipStructure)
- [Containers](#Containers)
    - [Standard](#Standard)
    - [Default](#Default)
    - [API](#API)
    - [CLI](#CLI)
    - [WEB](#WEB)
    - [Full](#Full)
- [Laravel console commands](#LaravelConsoleCommands)
    - [Make](#Make)
      - [make:cast](#makeCast)
      - [make:channel](#makeChannel)
      - [make:command](#makeCommand)
      - [make:component](#makeComponent)
      - [make:controller](#makeController)
      - [make:event](#makeEvent)
      - [make:exception](#makeException)
      - [make:factory](#makeFactory)
      - [make:job](#makeJob)
      - [make:listener](#makeListener)
      - [make:mail](#makeMail)
      - [make:middleware](#makeMiddleware)
      - [make:model](#makeModel)
      - [make:notification](#makeNotification)
      - [make:observer](#makeObserver)
      - [make:policy](#makePolicy)
      - [make:provider](#makeProvider)
      - [make:request](#makeRequest)
      - [make:resource](#makeResource)
      - [make:rule](#makeRule)
      - [make:scope](#makeScope)
      - [make:seeder](#makeSeeder)
      - [make:test](#makeTest)
    - [Model](#model)
      - [model:show](#modelShow)

<a id="Introduction"></a>
# Introduction

Laravel is a popular and beautiful PHP framework who helps a lot to make your web applications. 
But web applications tend to grow and become harder to maintain and optimize.
Unfortunately, Laravel, like other frameworks, does not have standard tools that allow you to write flexible, 
readable and easily maintainable code.

Porto (Software Architectural Pattern) is a brilliant solution for building large applications.
This pattern helps you and your team to organize and maintain your code. 

You can find more information about Porto by this link: https://github.com/Mahmoudz/Porto

<a id="HowToInstall?"></a>
# How to install?

1. First of all you need to install the package:
    ```
    composer require alxdorosenco/porto-for-laravel
    ```
2. Next, you need to enable installed package in your .env file: 
    ```
   PORTO_ENABLED=true
    ```
3. Next, you can install porto structure using this command: 
   ```
   php artisan porto:install --container=<Container Name> --container-<Container Type>
   ```  
   You need to put directory path when the Porto structure will be installed 
   or you can confirm installation in the default app/ directory. 

   You also can add directory name of your first container.
   For example: 
   ```
   --container=<Container Name>
   ```
   This container will be installed in the Containers directory with standard structure.
   You also can force another container structures like:
   ```
   --container-default
   --container-api
   --container-cli
   --container-web
   --container-full
   ```
4. Next, you need to put some changes in the bootstrap/app.php file.

   From:
   ```php
    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        App\Http\Kernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        App\Console\Kernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        App\Exceptions\Handler::class
    );
   ```
   To: 
   ```php
    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        <Porto path name>\Ship\Kernels\HttpKernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        <Porto path name>\Ship\Kernels\ConsoleKernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        <Porto path name>\Ship\Exceptions\Handler::class
    );
   ```
5. At last, you need to comment or clear Application Service Providers in the file config/app.php. 
   Because you don't need them. The package loads automatically all providers from Ship and Containers
   ```php
   /*
   * Application Service Providers...
   */
   //App\Providers\AppServiceProvider::class,
   //App\Providers\AuthServiceProvider::class,
   // App\Providers\BroadcastServiceProvider::class,
   //App\Providers\EventServiceProvider::class,
   //App\Providers\RouteServiceProvider::class
   ```
6. That's all. 
   Below you can find the skeleton structure of ship, each type of containers 
   and information about adapted laravel console commands.

<a id="ShipStructure"></a>
# Ship structure

This is a skeleton of the installed Ship structure.

```
Ship
    ├── Abstracts
    │   ├── Broadcasting
    │   │   ├── Channel.php
    │   │   ├── PresenceChannel.php
    │   │   └── PrivateChannel.php
    │   │── Commands
    │	│   └── ConsoleCommand.php
    │   ├── Components
    │	│   └── Component.php
    │   ├── Controllers
    │	│   └── Controller.php
    │   ├── Events
    │	│   └── Event.php
    │   ├── Exceptions
    │	│   └── Handler.php
    │   ├── Factories
    │	│   └── Factory.php
    │   ├── Jobs
    │	│   └── Job.php
    │   ├── Mails
    │	│   ├── Mailables
    │	│   │   ├── Content.php
    │	│   │   └── Envelope.php
    │	│   └── Mailable.php
    │   ├── Middleware
    │   │   ├── Authenticate.php
    │   │   ├── EncryptCookies.php
    │   │   ├── PreventRequestsDuringMaintenance.php
    │   │   ├── TrimStrings.php
    │   │   ├── TrustHosts.php
    │   │   ├── TrustProxies.php
    │   │   ├── ValidateSignature.php
    │   │   └── VerifyCsrfToken.php
    │   ├── Models
    │   │   ├── BaseModel.php
    │   │   ├── UserModel.php
    │   │   ├── Pivot.php
    │   │   ├── MorphPivot.php
    │   │   └── Builder.php
    │   ├── Notifications
    │	│   ├── Messages
    │	│   │   └── MailMessage.php
    │   │   └── Notification.php
    │   ├── Policies
    │	│   └── Policy.php
    │   ├── Providers
    │   │   ├── AuthServiceProvider.php
    │   │   ├── ServiceProvider.php
    │   │   ├── EventServiceProvider.php
    │   │   └── RouteServiceProvider.php
    │   ├── Requests
    │   │   ├── Request.php
    │   │   └── FormRequest.php
    │   ├── Responses
    │   │   ├── Response.php
    │   │   ├── RedirectResponse.php
    │   │   └── JsonResource.php
    │   ├── Resources
    │	│   └── ResourceCollection.php
    │   ├── Seeders
    │	│   └── Seeder.php
    │   ├── Tests
    │	│   └── PhpUnit
    │	│       └── TestCase.php
    │   ├── Translations
    │	│   └── PotentiallyTranslatedString.php
    │   └── Views
    │	    └── Component.php
    ├── Broadcasting
    │   ├── Channel.php
    │   ├── PresenceChannel.php
    │   └── PrivateChannel.php
    ├── Configs
    ├── Controllers
    │   └── Controller.php
    ├── Events
    │   └── Event.php 
    ├── Exceptions
    │   └── Handler.php
    ├── Helpers
    │   └── helper.php
    ├── Kernels
    │   ├── ConsoleKernel.php
    │   └── HttpKernel.php 
    ├── Mails
    │   └── Mailables
    │       ├── Envelope.php
    │       └── Content.php
    ├── Middleware
    │   ├── Authenticate.php
    │   ├── EncryptCookies.php
    │   ├── PreventRequestsDuringMaintenance.php
    │   ├── RedirectIfAuthenticated.php
    │   ├── TrimStrings.php
    │   ├── TrustHosts.php
    │   ├── TrustProxies.php
    │   ├── ValidateSignature.php
    │   └── VerifyCsrfToken.php
    ├── Migrations
    ├── Models
    │   ├── Model.php
    │   ├── UserModel.php
    │   ├── Pivot.php
    │   ├── MorphPivot.php
    │   ├── Builder.php
    │   └── Scope.php
    ├── Notifications
    │   ├── Messages
    │   │   └── MailMessage.php
    │   └── Notification.php
    ├── Policies
    │   └── Policy.php
    ├── Providers
    │   ├── AuthServiceProvider.php
    │   ├── BroadcastServiceProvider.php
    │   ├── EventServiceProvider.php
    │   └── RouteServiceProvider.php
    ├── Requests
    │   ├── Request.php
    │   └── FormRequest.php
    ├── Responses
    │   ├── Response.php
    │   └── RedirectResponse.php
    ├── Resources
    │   ├── JsonResource.php
    │   └── ResourceCollection.php
    ├── Tests
    │   └── TestCase.php
    ├── Traits
    │   └── CreatesApplication.php
    └── Translations
```

<a id="Containers"></a>
# Containers

<a id="Standard"></a>
## 1. Standard

To create container with necessary files and folders you need to put this command:
```
php artisan make:container <Name>
```
Without forced container type will be created standard container structure.  

#### Standard Container's Structure

```
Container
	├── Actions
	├── Tasks
	├── Models
	├── Loaders
	│   ├── AliasesLoader.php
	│   ├── ProvidersLoader.php
	│   └── MiddlewareLoader.php  
	└── UI
	    ├── WEB
	    │   ├── Routes
	    │   ├── Controllers
	    │   └── Views
	    ├── API
	    │   ├── Routes
	    │   ├── Controllers
	    │   └── Transformers
	    └── CLI
	        ├── Routes
	        └── Commands
```

<a id="Default"></a>
## 2. Default

To create container with default route, controller, view and test file you can via command below:

```
php artisan make:container <Name> --default
```

#### Default Container's Structure

```
Container
	├── Actions
	├── Tasks
	├── Models
	├── Loaders
	│   ├── AliasesLoader.php
	│   ├── ProvidersLoader.php
	│   └── MiddlewareLoader.php  
	└── UI
	    ├── WEB
	    │   ├── Routes
	    │   │   ├── home.php
	    │   ├── Controllers
	    │   │   ├── HomeController.php 
	    │   ├── Views
	    │   │   ├── home.blade.php
	    │   ├── Tests
	    │   │   ├── Functional
	    │   └── └── └── ExampleTest.php 
	    ├── API
	    │   ├── Routes
	    │   ├── Controllers
	    │   └── Transformers
	    └── CLI
	        ├── Routes
	        └── Commands
```

<a id="API"></a>
## 3. API

To create container only for API needles you can via command below:

```
php artisan make:container <Name> --api
```

#### API Container's Structure

```
Container
	├── Actions
	├── Tasks
	├── Models
	├── Loaders
	│   ├── AliasesLoader.php
	│   ├── ProvidersLoader.php
	│   └── MiddlewareLoader.php  
	└── UI
	    └── API
	        ├── Routes
	        ├── Controllers
	        └── Transformers
```

<a id="CLI"></a>
## 4. CLI

To create container only for command line interface needles you can via command below:

```
php artisan make:container <Name> --cli
```

#### CLI Container's Structure

```
Container
	├── Actions
	├── Tasks
	├── Models
	├── Loaders
	│   ├── AliasesLoader.php
	│   ├── ProvidersLoader.php
	│   └── MiddlewareLoader.php  
	└── UI
	    └── CLI
	        ├── Routes
	        └── Commands
```

<a id="WEB"></a>
## 5. WEB

To create container only for web needles you can via command below:

```
php artisan make:container <Name> --web
```

#### WEB Container's Structure

```
Container
	├── Actions
	├── Tasks
	├── Models
	├── Loaders
	│   ├── AliasesLoader.php
	│   ├── ProvidersLoader.php
	│   └── MiddlewareLoader.php  
	└── UI
	    └── WEB
	        ├── Routes
	        ├── Controllers
	        └── Views
```

<a id="Full"></a>
## 6. Full

To create container with full structure you can via command below:

```
php artisan make:container <Name> --full
```

#### Full Container's Structure

```
Container
	├── Actions
	├── Tasks
	├── Models
	├── Values
	├── Events
	├── Listeners
	├── Policies
	├── Exceptions
	├── Contracts
	├── Traits
	├── Jobs
	├── Notifications
	├── Providers
	├── Configs
	├── Loaders
	│   ├── AliasesLoader.php
	│   ├── ProvidersLoader.php
	│   └── MiddlewareLoader.php
	├── Mails
	│   └── Templates
	├── Data
	│   ├── Migrations
	│   ├── Seeders
	│   ├── Factories
	│   ├── Criteria
	│   ├── Repositories
	│   ├── Validators
	│   ├── Transporters
	│   └── Rules
	├── Tests
	│   ├── Traits
	│   └── Unit
	└── UI
	    ├── WEB
	    │   ├── Routes
	    │   ├── Controllers
	    │   ├── Requests
	    │   ├── Tests
	    │   │   └── Functional
	    │   └── Views
	    ├── API
	    │   ├── Routes
	    │   ├── Controllers
	    │   ├── Requests
	    │   ├── Tests
	    │   │   └── Functional
	    │   └── Transformers
	    └── CLI
	        ├── Routes
	        ├── Commands
	        └── Tests
	            └── Functional
```

<a id="LaravelConsoleCommands"></a>
# Laravel console commands

<a id="Make"></a>
## 1. Make

This is a list of adapted laravel console commands for the Porto.

Without container name some commands will be created class in the Ship.

Other commands require the container name

<a id="makeCast"></a>
### make:cast

```
php artisan make:cast <Name> --container=<Container Name>
```

<a id="makeChannel"></a>
### make:channel

```
php artisan make:channel <Name> --container=<Container Name>
```

<a id="makeCommand"></a>
### make:command

```
php artisan make:command <Name>
php artisan make:command <Name> --container=<Container Name>
```

<a id="makeComponent"></a>
### make:component

```
php artisan make:component <Name> --container=<Container Name>
```

<a id="makeController"></a>
### make:controller

```
php artisan make:controller <Name> --container=<Container Name>
```

<a id="makeEvent"></a>
### make:event

```
php artisan make:event <Name>
php artisan make:event <Name> --container=<Container Name>
```

<a id="makeException"></a>
### make:exception

```
php artisan make:exception <Name>
php artisan make:exception <Name> --container=<Container Name>
```

<a id="makeFactory"></a>
### make:factory

```
php artisan make:factory <Name> --container=<Container Name>
```

<a id="makeJob"></a>
### make:job

```
php artisan make:job <Name>
php artisan make:job <Name> --container=<Container Name>
```

<a id="makeListener"></a>
### make:listener

```
php artisan make:listener <Name> --container=<Container Name>
```

<a id="makeMail"></a>
### make:mail

```
php artisan make:mail <Name>
php artisan make:mail <Name> --container=<Container Name>
```

<a id="makeMiddleware"></a>
### make:middleware

```
php artisan make:middleware <Name>
php artisan make:middleware <Name> --container=<Container Name>
```

<a id="makeModel"></a>
### make:model

```
php artisan make:model <Name> --container=<Container Name>
```

<a id="makeNotification"></a>
### make:notification

```
php artisan make:notification <Name>
php artisan make:notification <Name> --container=<Container Name>
```

<a id="makeObserver"></a>
### make:observer

```
php artisan make:observer <Name> --container=<Container Name>
```

<a id="makePolicy"></a>
### make:policy

```
php artisan make:policy <Name> --container=<Container Name>
```

<a id="makeProvider"></a>
### make:provider

```
php artisan make:provider <Name>
php artisan make:provider <Name> --container=<Container Name>
```

<a id="makeRequest"></a>
### make:request

```
php artisan make:request <Name> --container=<Container Name> --uiType=api
php artisan make:request <Name> --container=<Container Name> --uiType=web
```

<a id="makeResource"></a>
### make:resource

```
php artisan make:resource <Name> --container=<Container Name>
```

<a id="makeRule"></a>
### make:rule

```
php artisan make:rule <Name> --container=<Container Name>
```

<a id="makeScope"></a>
### make:scope

```
php artisan make:scope <Name> --container=<Container Name>
```

<a id="makeSeeder"></a>
### make:seeder

```
php artisan make:seeder <Name>
php artisan make:seeder <Name> --container=<Container Name>
```

<a id="makeTest"></a>
### make:test

```
php artisan make:test <Name> --container=<Container Name> --uiType=api
php artisan make:test <Name> --container=<Container Name> --uiType=cli
php artisan make:test <Name> --container=<Container Name> --uiType=web
```

<a id="model"></a>
## 2. Model

<a id="modelShow"></a>
### make:show

```
php artisan make:show --container=<Container Name>
```

## License
Released under the MIT License, see [LICENSE](LICENSE).
