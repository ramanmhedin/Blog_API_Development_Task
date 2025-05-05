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
        $route = $this->route()->getName();

        return match ($route) {
            'index' => $this->indexRules(),
            'store' => $this->storeRules(),
            'update' => $this->updateRules(),
            default => [],
        };
    }

    private function indexRules(): array
    {
        return [
            'search'=>['nullable','string'],

            //Order And Pagination
            'order_by' => ['nullable','string'],
            'sort' => ['nullable','string','in:desc,asc'],
            'per_page' => ['nullable','integer','min:1'],
            'page' => ['nullable','integer','min:1'],
        ];
    }

    private function storeRules(): array
    {
        return [
            "name" => ['required','string','max:255','unique:categories,name'],
            "description" => ['nullable','string','max:255']
        ];
    }

    private function updateRules(): array
    {
        $categoryId = $this->route('id');

        return [
            "name"=>['sometimes','string','max:255','unique:categories,name,'.$categoryId],
            "description" => ['sometimes','string','max:255']
        ];
    }
}
