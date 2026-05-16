<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarLibroTemasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dictado_id'               => 'required|integer',
            'fecha'                    => 'required|date',
            'objetivo_clase'           => 'nullable|string|max:500',
            'contenidos_vistos'        => 'nullable|string|max:1000',
            'actividades'              => 'nullable|string|max:1000',
            'observaciones'            => 'nullable|string|max:1000',
            'observador_clase'         => 'nullable|string|max:255',
            'id_estado_clase'          => 'nullable|integer|exists:docentes_estados_clases,id',
            'observacion_estado_clase' => 'nullable|string|max:400',
        ];
    }
}
