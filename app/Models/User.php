<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Un docente tiene muchas asignaciones (materia + curso + grupo)
    // Desde acá podemos saber qué materias/cursos/grupos le corresponden
    public function docenteMaterias()
    {
        return $this->hasMany(DocenteMateria::class, 'user_id');
    }

    // Un docente tiene muchos registros de clase (asistencias + libro de temas)
    public function registrosClase()
    {
        return $this->hasMany(RegistroClase::class, 'docente_id');
    }
}
