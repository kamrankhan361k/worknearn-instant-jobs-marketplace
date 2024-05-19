<?php

namespace App\Http\Requests;

use App\Rules\FileTypeValidate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'category_id' => "required|unique:categories,name",
            'sub_category_id' => "required|unique:sub_categories,name",
            'title' => "required",
            'quantity' => "required|min:0",
            'total_budge' => "required|min:0",
            'avg_time' => "required",
            'per_worker_earn' => "required|min:0",
            'description' => "required",
            'image' => ['max:3072','required','image', new FileTypeValidate(['jpg','jpeg','png','JPG','JPEG','PNG'])]
        ];
        if (request()->method() == "PUT" && request()->old_image) {
            $rules['image'] = ['max:3072','image', new FileTypeValidate(['jpg','jpeg','png','JPG','JPEG','PNG'])];
        }
        return $rules;
    }
}
