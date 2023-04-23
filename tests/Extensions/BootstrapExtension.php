<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Extensions;

use PHPUnit\Runner\Extension\Extension as PhpunitExtension;
use PHPUnit\Runner\Extension\Facade as EventFacade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;

class BootstrapExtension implements PhpunitExtension
{
    /**
     * @param Configuration $configuration
     * @param EventFacade $facade
     * @param ParameterCollection $collection
     * @return void
     */
    public function bootstrap(Configuration $configuration, EventFacade $facade, ParameterCollection $collection): void
    {
        $facade->registerSubscriber(
            new ApplicationFinishedSubscriber()
        );
    }
}
