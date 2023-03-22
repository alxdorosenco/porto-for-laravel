<?php

namespace AlxDorosenco\PortoForLaravel\Tests\Traits;

trait RequestsContent
{
    /**
     * @param string $name
     * @return string
     */
    public function getRequestContent(string $name, string $namespace): string
    {
        return <<<Class
<?php

namespace {$this->portoPathUcFirst()}\\$namespace

use {$this->portoPathUcFirst()}\Ship\Requests\FormRequest;

class $name extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
Class;
    }
}
