<?php

namespace App\Http\Requests\Tenants;

use App\Enums\RolePermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
        $permissionValues = array_map(fn($case) => $case->value, RolePermission::cases());

        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => [
                'required',
                'array',
                Rule::in($permissionValues), 
            ],
            'permissions.*' => [
                'string',
                Rule::in($permissionValues),
            ],
        ];
    }
}