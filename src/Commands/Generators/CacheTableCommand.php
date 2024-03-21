<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleGenerator;
use Illuminate\Cache\Console\CacheTableCommand as LaravelCacheTableCommand;

class CacheTableCommand extends LaravelCacheTableCommand
{
    use ConsoleGenerator;
}
