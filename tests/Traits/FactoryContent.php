<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait FactoryContent
{
    /**
     * @param string $modelNamespace
     * @param string $modelName
     * @return string
     */
    private function getFactoryContent(string $modelNamespace, string $modelName): string
    {
        return "<?php

/** @var \\{$this->portoPathUcFirst()}\Ship\Abstracts\Factories\Factory ".'$factory'." */

use Faker\Generator as Faker;
use {$this->portoPathUcFirst()}\\$modelNamespace;

".'$factory'."->define($modelName::class, function (Faker ".'$faker'.") {
    return [
        //
    ];
});
";
    }
}
