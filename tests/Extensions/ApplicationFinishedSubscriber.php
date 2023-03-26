<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Extensions;

use PHPUnit\Event\Application\Finished;
use PHPUnit\Event\Application\FinishedSubscriber as FinishedSubscriberInterface;

class ApplicationFinishedSubscriber implements FinishedSubscriberInterface
{
    /**
     * @param Finished $event
     * @return void
     */
    public function notify(Finished $event): void
    {
        $shipPath = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Ship';
        $containersPath = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Containers';

        if(PHP_OS_FAMILY === 'Windows'){
            exec('rmdir /S /Q '. $shipPath);
            exec('rmdir /S /Q '. $containersPath);
        } else {
            exec('rm -rf '. $shipPath);
            exec('rm -rf '. $containersPath);
        }

        print __METHOD__ . PHP_EOL . $shipPath. ' and '.$containersPath.' has been removed' . PHP_EOL;
    }
}
