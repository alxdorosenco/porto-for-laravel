<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait ModelsContent
{
    /**
     * @param string $name
     * @return string
     */
    public function getModelContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models;

use {$this->portoPathUcFirst()}\Ship\Models\Model;

class $name extends Model
{

}

Class;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getModelPivotContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models;

use {$this->portoPathUcFirst()}\Ship\Models\Pivot;

class $name extends Pivot
{
    //
}

Class;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getModelMorphPivotContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models;

use {$this->portoPathUcFirst()}\Ship\Models\MorphPivot;

class $name extends MorphPivot
{
    //
}

Class;
    }
}
