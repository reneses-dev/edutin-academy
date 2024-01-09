<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $slug = request()->isMethod('PUT') ? 'required|unique:categories,slug,'.$this->id : 'required|unique:categories,slug';
        $image = request()->isMethod('PUT') ? 'nullable|image' : 'required|image';
        return [
            'name' => 'required|max:255',
            'slug' => $slug,
            'image' => $image,
            'is_featured' => 'required|boolean',
            'status' => 'required|boolean'
        ];
    }
}
