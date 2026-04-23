<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Tabla: usuarios_roles
// Catálogo de roles del sistema (ej: Administrador, Docente, etc.).
class UsuarioRol extends Model
{
    protected $table = 'usuarios_roles';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'mxm_usuarios_usuarios_roles',
            'id_rol',
            'id_usuario'
        );
    }
}
