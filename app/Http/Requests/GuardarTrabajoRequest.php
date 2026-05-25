<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarTrabajoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $alumnos = $this->input('alumnos', []);

        foreach ($alumnos as $id => $alumno) {
            foreach (['nota_individual', 'nota_grupal'] as $campo) {
                if (isset($alumno[$campo]) && $alumno[$campo] !== '') {
                    $alumnos[$id][$campo] = str_replace(',', '.', $alumno[$campo]);
                }
            }
        }

        $this->merge(['alumnos' => $alumnos]);
    }

    public function rules(): array
    {
        return [
            'dictados'                  => 'required|array|min:1',
            'dictados.*'                => 'integer',
            'titulo'                    => 'required|string|max:255',
            'descripcion'               => 'nullable|string|max:400',
            'numero_trabajo'            => 'nullable|integer|min:1',
            'fecha_apertura'            => 'nullable|date',
            'fecha_cierre'              => 'nullable|date',
            'enlace'                    => 'nullable|string|max:255|url',
            'alumnos'                   => 'nullable|array',
            'alumnos.*.grupo'           => 'nullable|string|max:1',
            'alumnos.*.nota_individual' => 'nullable|numeric|min:0|max:10',
            'alumnos.*.nota_grupal'     => 'nullable|numeric|min:0|max:10',
            'alumnos.*.observaciones'   => 'nullable|string|max:400',
        ];
    }
}
