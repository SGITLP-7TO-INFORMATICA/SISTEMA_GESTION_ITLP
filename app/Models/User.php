<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    // Columnas reales de la tabla usuarios
    protected $fillable = [
        'nombre_usuario', 'nombre', 'apellido', 'email', 'contrasenia',
    ];

    protected $hidden = [
        'contrasenia', 'remember_token',
    ];

    // Nombres reales de las columnas de timestamps en la BD
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    // Le dice a Laravel qué columna usar como contraseña para Auth::attempt()
    public function getAuthPasswordName(): string
    {
        return 'contrasenia';
    }

    protected function casts(): array
    {
        return [
            'contrasenia' => 'hashed',
        ];
    }

    // Un docente tiene muchos registros de clase
    public function registrosClase()
    {
        return $this->hasMany(RegistroClase::class, 'id_Usuario_Verificador');
    }
}
