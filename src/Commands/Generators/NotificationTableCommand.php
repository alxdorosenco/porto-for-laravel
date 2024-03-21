<?php

namespace AlxDorosenco\PortoForLaravel\Commands\Generators;

use Illuminate\Notifications\Console\NotificationTableCommand as LaravelNotificationTableCommand;
use AlxDorosenco\PortoForLaravel\Commands\Traits\ConsoleMigrationGenerator;

class NotificationTableCommand extends LaravelNotificationTableCommand
{
    use ConsoleMigrationGenerator;
}
