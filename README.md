# Porto for Laravel

This is a package who gives flexible way to build a structure of the 
Porto (Software Architectural Pattern) in your Laravel project.
You should no longer to migrate a lot of files and folders handly. 
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
      - [make:export](#makeExport)
      - [make:factory](#makeFactory)
      - [make:import](#makeImport)
      - [make:job](#makeJob)
      - [make:listener](#makeListener)
      - [make:mail](#makeMail)
      - [make:mail](#makeMiddleware)
      - [make:mail](#makeMigration)
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

<a id="HowToInstall?"></a>
# How to install?

<a id="ShipStructure"></a>
# Ship structure

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

<a id="makeCast"></a>
<details>
    <summary>make:cast</summary>
</details>

<a id="makeChannel"></a>
<details>
    <summary>make:channel</summary>
</details>

<a id="makeCommand"></a>
<details>
    <summary>make:command</summary>
</details>

<a id="makeComponent"></a>
<details>
    <summary>make:component</summary>
</details>

<a id="makeController"></a>
<details>
    <summary>make:controller</summary>
</details>

<a id="makeEvent"></a>
<details>
    <summary>make:event</summary>
</details>

<a id="makeException"></a>
<details>
    <summary>make:exception</summary>
</details>

<a id="makeExport"></a>
<details>
    <summary>make:export</summary>
</details>

<a id="makeFactory"></a>
<details>
    <summary>make:factory</summary>
</details>

<a id="makeImport"></a>
<details>
    <summary>make:import</summary>
</details>

<a id="makeJob"></a>
<details>
    <summary>make:job</summary>
</details>

<a id="makeListener"></a>
<details>
    <summary>make:listener</summary>
</details>

<a id="makeMail"></a>
<details>
    <summary>make:mail</summary>
</details>

<a id="makeMiddleware"></a>
<details>
    <summary>make:middleware</summary>
</details>

<a id="makeMigration"></a>
<details>
    <summary>make:migration</summary>
</details>

<a id="makeModel"></a>
<details>
    <summary>make:model</summary>
</details>

<a id="makeNotification"></a>
<details>
    <summary>make:notification</summary>
</details>

<a id="makeObserver"></a>
<details>
    <summary>make:observer</summary>
</details>

<a id="makePolicy"></a>
<details>
    <summary>make:policy</summary>
</details>

<a id="makeProvider"></a>
<details>
    <summary>make:provider</summary>
</details>

<a id="makeRequest"></a>
<details>
    <summary>make:request</summary>
</details>

<a id="makeResource"></a>
<details>
    <summary>make:resource</summary>
</details>

<a id="makeRule"></a>
<details>
    <summary>make:rule</summary>
</details>

<a id="makeScope"></a>
<details>
    <summary>make:scope</summary>
</details>

<a id="makeSeeder"></a>
<details>
    <summary>make:seeder</summary>
</details>

<a id="makeTest"></a>
<details>
    <summary>make:test</summary>
</details>

<a id="model"></a>
## 2. Model

<a id="modelShow"></a>
<details>
    <summary>model:show</summary>
</details>
