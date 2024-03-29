<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait PolicyContent
{
    /**
     * @param string $name
     * @return string
     */
    private function getPolicyContent(string $name): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Policies;

use {$this->portoPathUcFirst()}\Ship\Models\UserModel;
use {$this->portoPathUcFirst()}\Ship\Policies\Policy;

class $name extends Policy
{
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}

Class;

    }

    /**
     * @param string $name
     * @param string $model
     * @return string
     */
    private function getPolicyModelContent(string $name, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\Containers\\$this->containerName\Policies;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Models\UserModel;

class $name extends Policy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(UserModel ".'$userModel'.")
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserModel ".'$userModel'.")
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }
}
