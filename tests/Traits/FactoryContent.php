<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait FactoryContent
{
    /**
     * @param string $name
     * @param string $modelNamespace
     * @return string
     */
    private function getFactoryContent(string $name, string $modelNamespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Data\Factories;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Factories\Factory;

/**
 * @extends \\{$this->portoPathUcFirst()}\Ship\Abstracts\Factories\Factory<\\{$this->portoPathUcFirst()}\\$modelNamespace>
 */
class $name extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }
}

Class;
    }
}
