<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Listeners;

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;

class EndTestSuiteListener implements TestListener
{
    use TestListenerDefaultImplementation;

    public function endTestSuite(TestSuite $suite)
    {
        if(stripos($suite->getName(), 'ValueMakeCommandTest') !== false){
            $shipPath = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Ship';
            $containersPath = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Containers';

            if(PHP_OS_FAMILY === 'Windows'){
                exec('rmdir /S /Q '. $shipPath);
                exec('rmdir /S /Q '. $containersPath);
            } else {
                exec('rm -rf '. $shipPath);
                exec('rm -rf '. $containersPath);
            }

            exec('composer dump-autoload');
        }
    }
}