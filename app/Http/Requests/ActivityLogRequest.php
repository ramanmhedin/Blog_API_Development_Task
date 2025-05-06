<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityLogRequest extends FormRequest
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
        return [
            "search" => ['nullable','string','max:255'],
            "type_of_action" => ['nullable','string','in:CREATE,UPDATE,DELETE,READ'],
            "entity_type" => ['nullable','required_with:entity_id'],
            "entity_id" => ['nullable','integer'],
            'from_date' => ['nullable','date'],
            'to_date' => ['nullable','date'],

            //Order And Pagination
            'order_by' => ['nullable','string'],
            'sort' => ['nullable','string','in:desc,asc'],
            'per_page' => ['nullable','integer','min:1'],
            'page' => ['nullable','integer','min:1'],
        ];
    }
}
