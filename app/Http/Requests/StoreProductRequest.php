<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'price' => ['required'],
            'description' => ['required'],
            'category' => ['required'],
            'image' => ['nullable']
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'image_url' => $this->image
        ]);
    }

    public function messages(): array {
        return [
            'name.required' => 'A name is required.',
            'name.unique' => 'A product with this name already exists.',
            'name.max' => 'The name must exceed 255 characters.',
            'price' => 'The product must contain a price.',
            'description' => 'The product must contain a description.',
            'category' => 'The product must contain a category.'
        ];
    }
}
