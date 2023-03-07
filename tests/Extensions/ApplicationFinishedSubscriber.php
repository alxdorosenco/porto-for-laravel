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
        $path = base_path().DIRECTORY_SEPARATOR.'PortoTestStructure';

        if(PHP_OS_FAMILY === 'Windows'){
            exec('rmdir /S /Q '. $path);
        } else {
            exec('rm -rf '. $path);
        }

        print __METHOD__ . PHP_EOL . $path. ' has been removed' . PHP_EOL;
    }
}
