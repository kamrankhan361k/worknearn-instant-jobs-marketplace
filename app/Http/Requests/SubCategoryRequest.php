<?php

namespace App\Http\Requests;

use App\Rules\FileTypeValidate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' =>"required|unique:sub_categories,name",
            'category_id' =>"required",
            'status' => "required|" . Rule::in(['1', '0']),
        ];
        if (request()->method() == "PUT") {
            $rules['name'] = "required|unique:categories,name," . $this->subCategory->id;
        }
        return $rules;
    }
}
