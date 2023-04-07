<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait SeedContent
{
    /**
     * @param string $name
     * @return string
     */
    private function getSeederContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Abstracts\Seeders\Seeder;

class $name extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }
}

Class;

    }
}
