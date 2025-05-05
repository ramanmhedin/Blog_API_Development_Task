<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'search' => ['nullable','string'],
            'category_slug'=> ['nullable','string','exists:categories,slug'],
            'category_id'=> ['nullable','integer','exists:categories,id'],
            'from_date' => ['nullable','date'],
            'to_date' => ['nullable','date'],

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
            'title' => ['required','string','max:255'],
            'content' => ['required','string','max:255'],
            'category_id' => ['required','integer','exists:categories,id']
        ];
    }

    private function updateRules(): array
    {
        return [
            'title' => ['sometimes','string','max:255'],
            'content' => ['sometimes','string','max:255'],
            'category_id' => ['sometimes','integer','exists:categories,id']
        ];
    }
}
