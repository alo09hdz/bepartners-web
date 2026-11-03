<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'lider']);
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'      => ['required', Rule::in(array_keys(Project::STATUSES))],
            'members'     => ['nullable', 'array'],
            'members.*'   => ['exists:users,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nombre',
            'description' => 'descripción',
            'start_date'  => 'fecha de inicio',
            'end_date'    => 'fecha de fin',
            'status'      => 'estado',
            'members'     => 'integrantes',
        ];
    }

    public function messages(): array
    {
        return [
            'required'             => 'El campo :attribute es obligatorio.',
            'max'                  => 'El campo :attribute no puede tener más de :max caracteres.',
            'date'                 => 'El campo :attribute no es una fecha válida.',
            'end_date.after_or_equal' => 'La fecha de fin no puede ser anterior a la de inicio.',
        ];
    }
}