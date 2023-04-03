<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait ControllersContent
{
    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerApiContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show(".'$id'.")
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", ".'$id'.")
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy(".'$id'.")
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerInvokableContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function __invoke(Request ".'$request'.")
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerModelContent(string $name, string $namespace, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerModelRequestContent(string $name, string $namespace, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerModelApiContent(string $name, string $namespace, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerModelApiRequestContent(string $name, string $namespace, string $model): string
    {
        $modelVariable = lcfirst($model);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\UI\API\Requests\Store{$model}Request;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\UI\API\Requests\Update{$model}Request;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\UI\API\Requests\Store{$model}Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Store{$model}Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\UI\API\Requests\Update{$model}Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Update{$model}Request ".'$request'.", $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $modelVariable = lcfirst($model);
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedSingletonContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Show the form for creating the new resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create($parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Show the form for editing the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedApiContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $modelVariable = lcfirst($model);
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model  ".'$'."$modelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable, $model ".'$'."$modelVariable)
    {
        //
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerNestedSingletonApiContent(string $name, string $namespace, string $model, string $parentModel): string
    {
        $parentModelVariable = lcfirst($parentModel);

        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel;
use {$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$model;
use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show($parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", $parentModel ".'$'."$parentModelVariable)
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Containers\\$this->containerName\Models\\$parentModel  ".'$'."$parentModelVariable
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy($parentModel ".'$'."$parentModelVariable)
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerSingletonContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Show the form for creating the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.")
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy()
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerSingletonApiContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Store the newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.")
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy()
    {
        abort(404);
    }
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerPlainContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    //
}
";
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return string
     */
    private function getControllerContent(string $name, string $namespace): string
    {
        return "<?php

namespace {$this->portoPathUcFirst()}\\$namespace;

use {$this->portoPathUcFirst()}\Ship\Controllers\Controller;
use {$this->portoPathUcFirst()}\Ship\Requests\Request;

class $name extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function store(Request ".'$request'.")
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function show(".'$id'.")
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function edit(".'$id'.")
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \\{$this->portoPathUcFirst()}\Ship\Requests\Request  ".'$request'."
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function update(Request ".'$request'.", ".'$id'.")
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  ".'$id'."
     * @return \\{$this->portoPathUcFirst()}\Ship\Responses\Response
     */
    public function destroy(".'$id'.")
    {
        //
    }
}
";
    }
}
