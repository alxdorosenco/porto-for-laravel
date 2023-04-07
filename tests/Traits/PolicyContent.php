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

use {$this->portoPathUcFirst()}\Ship\Policies\Policy;
use {$this->portoPathUcFirst()}\Ship\Models\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class $name extends Policy
{
    use HandlesAuthorization;

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

use Illuminate\Auth\Access\HandlesAuthorization;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Models\UserModel;

class $name
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any DocDummyPluralModel.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @return mixed
     */
    public function viewAny(UserModel ".'$userModel'.")
    {
        //
    }

    /**
     * Determine whether the user can view the Doc$model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return mixed
     */
    public function view(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can create DocDummyPluralModel.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @return mixed
     */
    public function create(UserModel ".'$userModel'.")
    {
        //
    }

    /**
     * Determine whether the user can update the Doc$model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return mixed
     */
    public function update(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can delete the Doc$model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return mixed
     */
    public function delete(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can restore the Doc$model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return mixed
     */
    public function restore(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the Doc$model.
     *
     * @param  \App\Ship\Models\UserModel  ".'$userModel'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return mixed
     */
    public function forceDelete(UserModel ".'$userModel'.", $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }
}
