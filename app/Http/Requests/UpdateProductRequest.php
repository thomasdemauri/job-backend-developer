<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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

        if ($this->method() == 'PUT') {
            return [
                'name' => ['required', 'max:255'],
                'price' => ['required'],
                'description' => ['required'],
                'category' => ['required'],
                'image' => ['nullable']
            ];
        } else {
            return [
                'name' => ['sometimes', 'required', 'max:255'],
                'price' => ['sometimes', 'required'],
                'description' => ['sometimes', 'required'],
                'category' => ['sometimes', 'required'],
                'image' => ['sometimes', 'nullable']
            ];
        }
    }

    protected function prepareForValidation() {
        $this->merge([
            'image_url' => $this->image
        ]);
    }

    public function messages(): array {
        return [
            'name.required' => 'A name is required.',
            'name.max' => 'The name must exceed 255 characters.',
            'price' => 'The product must contain a price.',
            'description' => 'The product must contain a description.',
            'category' => 'The product must contain a category.'
        ];
    }
}
