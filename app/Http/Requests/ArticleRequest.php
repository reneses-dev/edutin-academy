<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
        $slug = request()->isMethod('PUT') ? 'required|unique:articles,slug,'.$this->id : 'required, unique:articles,slug';
        $image = request()->isMethod('PUT') ? 'nullable|mimes:jpeg,png,jpg,svg|max:8000' : 'required|image|mimes:jpeg,png,jpg,svg|max:8000';
        return [
            'title' => 'required', 'string', 'max:120',
            'slug' => $slug,
            'introduction' => 'required', 'min:10', 'max:255',
            'body' => 'required',
            'image' => $image,
            'status' => 'required|boolean',
            'category_id' => 'required|integer'
        ];
    }
}
