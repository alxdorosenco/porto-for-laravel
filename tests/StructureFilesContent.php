<?php

namespace AlxDorosenco\PortoForLaravel\Tests;

trait StructureFilesContent
{
    /**
     * @return string
     */
    protected function contentShipAbstractsBroadcastingChannel(): string
    {
        return <<<CLASS
<?php

namespace {$this->portoPath}\Ship\Abstracts\Broadcasting;

use Illuminate\Broadcasting\Channel as LaravelChannel;

abstract class Channel extends LaravelChannel
{

}

CLASS;
    }
}
