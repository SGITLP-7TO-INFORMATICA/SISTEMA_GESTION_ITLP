<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alumno_id'              => 'nullable|integer|exists:alumnos,id',
            'nombre'                 => 'required|string|max:255',
            'apellido'               => 'required|string|max:255',
            'legajo'                 => 'nullable|string|max:255',
            'Genero'                 => 'nullable|in:HOMBRE,MUJER,OTRO',
            'fecha_nacimiento'       => 'nullable|date',
            'fecha_ingreso'          => 'nullable|date',
            'id_curso_actual'        => 'nullable|integer|exists:alumnos_cursos,id',
            'id_grupo_taller_actual' => 'nullable|integer|exists:alumnos_cursos,id',
            'activo'                 => 'nullable|boolean',
        ];
    }
}
