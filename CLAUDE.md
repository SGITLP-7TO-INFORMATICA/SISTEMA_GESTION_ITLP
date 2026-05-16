# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Stack

- **Laravel 12**, PHP 8.2+
- **Livewire 3** — reactive UI components (no full-page JS framework)
- **Tailwind CSS 4** via Vite
- **MariaDB/MySQL** (`sgitlp`) — base de datos principal
- **PHPSpreadsheet** — Excel export
- **Queue/Session/Cache**: database driver

## Comandos frecuentes

```bash
# Desarrollo (servidor + queue + logs + Vite concurrentes)
composer run dev

# Solo frontend
npm run dev

# Solo servidor PHP
php artisan serve

# Linting (Laravel Pint)
./vendor/bin/pint

# Tests
composer run test
php artisan test --filter NombreDelTest
```

## Arquitectura por capas

El proyecto sigue una arquitectura monolítica por capas. Cada capa tiene una única responsabilidad:

```
HTTP Request
    ↓
Form Request  →  valida los datos de entrada
    ↓
Controller    →  coordina: llama la Action y devuelve la respuesta HTTP
    ↓
Action        →  ejecuta la lógica de escritura
    ↓
Vista SQL     →  resuelve la lógica de lectura (vive en la BD)
    ↓
Modelo        →  define estructura, relaciones, ejecuta insert/update
```

### Ejemplo concreto: guardar un registro en el Libro de Temas

El docente completa el formulario y hace click en "Guardar". Esto dispara un `POST /docentes/libro-temas` que recorre todas las capas:

**1. Form Request** — Laravel valida antes de llegar al controller. Si falla, redirige automáticamente con los errores.
```php
// app/Http/Requests/GuardarLibroTemasRequest.php
public function rules(): array
{
    return [
        'dictado_id'        => 'required|integer',
        'fecha'             => 'required|date',
        'contenidos_vistos' => 'nullable|string|max:1000',
        'id_estado_clase'   => 'nullable|integer|exists:docentes_estados_clases,id',
        // ...
    ];
}
```

**2. Controller** — recibe los datos ya validados, llama la Action, redirige.
```php
// app/Http/Controllers/DocenteController/DocenteController.php
public function guardarLibroTemas(GuardarLibroTemasRequest $request)
{
    $docente    = $this->getDocente();
    $registroId = $request->filled('registro_id') ? (int) $request->registro_id : null;

    $result = (new GuardarRegistroClase)->execute($request->validated(), $registroId, $docente->id);

    return redirect()->route('docentes.libro-temas')->with('success', $result['msg']);
}
```

**3. Action** — contiene toda la lógica: verificar duplicado, calcular número de clase, crear o actualizar.
```php
// app/Actions/GuardarRegistroClase.php
public function execute(array $datos, ?int $registroId, int $docenteId): array
{
    if ($registroId === null) {
        $yaExiste = DB::table('docentes_registro_clases')
            ->where('Id_Dictado_Materia', $datos['dictado_id'])
            ->where('Fecha_Clase', $datos['fecha'])
            ->exists();

        if ($yaExiste) {
            throw ValidationException::withMessages([
                'fecha' => 'Ya existe un registro de clase para esta materia en la fecha seleccionada.',
            ]);
        }
    }

    $numeroClase = $registroId !== null
        ? DB::table('docentes_registro_clases')->where('id', $registroId)->value('Numero_Clase')
        : DB::table('docentes_registro_clases')->where('Id_Dictado_Materia', $datos['dictado_id'])->count() + 1;

    $registro = RegistroClase::create([...]);
    return ['registroId' => $registro->id, 'msg' => 'Clase registrada en el libro de temas.'];
}
```

**4. Vista SQL** — usada en el GET previo (cuando el docente carga la página) para listar los registros existentes sin armar joins en PHP.
```php
// app/Http/Controllers/DocenteController/DocenteController.php — método libroTemas()
$registros = DB::table('view_docentes_registro_clases')
    ->where('DOCENTE_A_CARGO_ID', $docente->id)
    ->orderByDesc('REGISTRO_CLASE_FECHA')
    ->limit(20)
    ->get();
```

**5. Modelo** — define la estructura y ejecuta el insert. No contiene lógica de negocio.
```php
// app/Models/RegistroClase.php
class RegistroClase extends Model
{
    protected $table    = 'docentes_registro_clases';
    public $timestamps  = false;
    protected $fillable = ['Id_Dictado_Materia', 'Fecha_Clase', 'Numero_Clase', ...];
}
```

---

### Form Requests — `app/Http/Requests/`

Cada formulario importante tiene su propia clase. La validación no vive en el controller.

- `GuardarAlumnoRequest`
- `GuardarListaRequest`
- `GuardarLibroTemasRequest`
- `GuardarTrabajoRequest`

### Actions — `app/Actions/`

Cada operación de escritura compleja tiene su propia clase. Reciben los datos ya validados, ejecutan la lógica, y devuelven un resultado. No saben nada de HTTP ni de Request.

- `GuardarAlumno` — insert/update en tabla alumnos
- `GuardarListaAsistencia` — borra e inserta asistencias en bulk
- `GuardarRegistroClase` — verifica duplicado, calcula número de clase, crea/actualiza registro
- `GuardarTrabajo` — crea/actualiza trabajo, sincroniza pivot de dictados y notas de alumnos

También existe `ExportarRegistrosClasesExcel.php` dentro de `DocenteController/`, que sigue el mismo patrón para la exportación Excel.

### Controllers — `app/Http/Controllers/`

Los controllers son delgados. Su responsabilidad es: recibir el request, llamar la Action, y devolver la respuesta HTTP (redirect o JSON). No contienen lógica de negocio ni queries complejas.

Cada módulo tiene su propio subdirectorio:

- **DocenteController/** — libro de temas, tomar lista, trabajos prácticos, exportación Excel
- **DocenteAdminController/** — vista administrativa de docentes
- **AlumnoController/**, **CursoController/**, **MateriaController/**, **MateriaDictadoController/**, **AnioController/** — CRUD administrativo

Los métodos AJAX (que devuelven JSON) también viven en los controllers del módulo correspondiente. Son simples: validan el input, consultan una vista SQL, devuelven JSON.

### Livewire — `app/Livewire/`

Los componentes manejan tablas interactivas con filtros, búsqueda y paginación. Consultan vistas SQL directamente en `render()`, sin armar joins en PHP.

| Componente | Vista SQL que consulta |
|------------|----------------------|
| `AlumnosTable` | `view_alumnos_con_curso` |
| `DocentesTable` | `view_docentes_con_usuario` |
| `RegistrosClaseTable` | `view_docentes_registro_clases` |
| `TrabajosTable` | `view_docentes_materias_dictadas` |
| `AlumnosTrabajo` | `view_alumnos_por_dictado_con_curso` |
| `AlumnosCursosPanel` | `view_alumnos_con_curso` |

Patrón común de un componente:
- Propiedades públicas para filtros y estado (`$search`, `$filtroCurso`, `$selectedId`)
- `updatingSearch()` / `updatingFiltroX()` para resetear la paginación al filtrar
- `#[On('evento')]` para escuchar eventos desde Blade/JS
- `dispatch('evento', datos)` para comunicarse con el formulario principal de la página

### Modelos — `app/Models/`

Definen `$fillable`, relaciones (`hasMany`, `belongsToMany`) y accessors. Se usan principalmente para escritura (`create`, `update`, `updateOrCreate`). Las vistas SQL reemplazaron su rol en lectura.

Los timestamps (`fecha_creacion`, `fecha_actualizacion`) los gestionan **triggers de la BD**, no Laravel. Los modelos que los necesitan definen `const CREATED_AT` y `const UPDATED_AT` con el nombre real de la columna, o usan `public $timestamps = false` y manejan las fechas manualmente en los inserts.

### Autenticación

Sesiones con `Auth::attempt()`. El controlador `AuthController` soporta modo debug con `contrasenia_dev`. No usa tokens ni Sanctum — es puramente session-based con middleware `auth`.

La tabla de autenticación real es `usuarios`, no `users`. Campos propios: `nombre_usuario`, `contrasenia` (bcrypt), `contrasenia_dev` (texto plano, solo dev). El modelo `User` sobreescribe `getAuthPasswordName()` para apuntar a `contrasenia`.

## Vistas SQL

Las vistas SQL son la capa de lectura del sistema. Concentran los joins y combinaciones complejas; los controllers y Livewire hacen `DB::table('view_...')` con filtros simples encima. **No son modelos Eloquent.**

**Regla de joins:**
- Si escribís una query con **1 join**, avisá al usuario que existe ese join en el código.
- Si escribís una query con **2 o más joins**, avisá y sugerí crear una vista SQL en MariaDB para reemplazarla.

Las vistas se gestionan directamente en la BD — no se usan migraciones de Laravel para esto.

| Vista | Qué resuelve |
|-------|-------------|
| `view_docentes_materias_dictadas` | Dictados de un docente con materia, curso y horario del módulo |
| `view_docentes_registro_clases` | Registros de clase con estado, conteo de asistencias y datos del docente |
| `view_alumnos_por_dictado_docente` | Alumnos que corresponden a un dictado de un docente (combina inscripción individual y grupal) |
| `view_alumnos_con_curso` | Alumnos con su curso actual |
| `view_alumnos_por_dictado_con_curso` | Alumnos por dictado con nombre de curso, para trabajos prácticos |
| `view_docentes_con_usuario` | Docentes con datos de usuario vinculado |
| `view_cursos_con_anio_y_conteo` | Cursos con año lectivo y conteo de alumnos activos |
| `view_alumnos_materias_con_horario` | Materias en las que está inscripto un alumno con horario |
| `view_alumnos_asistencias_detalle` | Asistencias de un alumno con detalle de materia y horario |

## Convenciones de código

### Nomenclatura

| Elemento | Convención | Ejemplo |
|----------|-----------|---------|
| Controllers | PascalCase, carpeta propia | `DocenteController/DocenteController.php` |
| Actions | Verbo + sustantivo | `GuardarListaAsistencia` |
| Form Requests | Verbo + sustantivo + `Request` | `GuardarLibroTemasRequest` |
| Livewire | Sustantivo + tipo | `AlumnosTable`, `AlumnosCursosPanel` |
| Rutas | `modulo.accion` | `docentes.libro-temas`, `administracion.alumnos` |
| Vistas SQL | `view_entidad_descripcion` | `view_alumnos_con_curso` |

### Rutas

- Todas las rutas protegidas en un grupo `middleware('auth')` en `routes/web.php`
- Sin `Route::resource()` — rutas declaradas explícitamente con verbo, path y nombre
- Los endpoints JSON comparten controller con las rutas web del mismo módulo

### Comentarios

Se usan dos estilos, ninguno para describir lo que el código ya dice solo:

**Bloque separador** — para dividir secciones grandes dentro de un archivo:
```php
// ──────────────────────────────────────────────
// LIBRO DE TEMAS
// ──────────────────────────────────────────────
```

**Línea explicativa** — para aclarar el *por qué* o el contexto de algo no obvio:
```php
// Dictados del docente, incluyendo día y horario del módulo para el blade
```

### Flujo de un formulario

```
1. Usuario envía el form (POST)
2. Form Request valida → si falla, Laravel devuelve errores automáticamente
3. Controller llama la Action con los datos validados
4. Action ejecuta la lógica de escritura y devuelve ['id' => ..., 'msg' => ...]
5. Controller hace redirect()->with('success', $msg)
6. Vista muestra el mensaje con session('success')
```

### Flujo de una tabla Livewire

```
1. Usuario filtra o busca (wire:model.live.debounce.300ms)
2. Livewire actualiza la propiedad y re-ejecuta render()
3. render() consulta la vista SQL con los filtros actuales
4. Usuario hace click en una fila → dispatch('cargar-registro', id)
5. JS/Alpine escucha el evento y pre-llena el formulario de la página
```

## Estructura base de datos

La BD es **MariaDB** (`sgitlp`). Los timestamps (`fecha_creacion`, `fecha_actualizacion`) los gestionan **triggers de DB**, no Laravel.

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| `usuarios` | Auth custom. Tiene `contrasenia_dev` para login de desarrollo. |
| `usuarios_roles` | Roles del sistema (`es_admin` flag). |
| `docentes` | Perfil del docente, vinculado a `usuarios`. |
| `alumnos` | Perfil del alumno. `activo` determina si aparece en listas. Tiene `id_curso_actual` e `id_grupo_taller_actual`. |
| `alumnos_cursos` | Cursos/divisiones (ej: "1°A Informática"). Referenciado por `alumnos`. |
| `alumnos_anios` | Años lectivos con modalidad (INFORMATICA / ELECTROMECANICA). |
| `materias` | Catálogo de materias con plan de estudios. |
| `materias_dictado` | Instancia de una materia en un año lectivo, con módulo horario asignado. Es la entidad central del sistema. |
| `materias_modulos` | Bloques horarios: día de la semana + hora desde/hasta. |
| `docentes_registro_clases` | Registro de cada clase dictada. **Unique:** `(Fecha_Clase, Id_Dictado_Materia)` — solo un registro por clase por día. |
| `docentes_estados_clases` | Estados posibles de una clase (con color para UI). |
| `alumnos_asistencias` | Asistencia de cada alumno a cada registro de clase. |
| `alumnos_asistencias_estados` | Estados de asistencia (ej: Presente=1, Ausente=2). |
| `docentes_trabajos` | Trabajos prácticos creados por docentes. |
| `alumnos_notas_trabajos` | Nota individual y grupal por alumno por trabajo. |

### Tablas pivot (prefijo `mxm_`)

| Tabla | Relación |
|-------|----------|
| `mxm_docente_materia_dictada` | Docente ↔ MateriaDictado (incluye `id_Docente_Rol`) |
| `mxm_alumnos_materias` | Alumno ↔ MateriaDictado (inscripción individual) |
| `mxm_cursos_materias_dictado` | Curso ↔ MateriaDictado (inscripción grupal) |
| `mxm_docentes_trabajos_dictados` | Trabajo ↔ MateriaDictado |
| `mxm_usuarios_usuarios_roles` | Usuario ↔ Rol |

### Relación clave: cómo un alumno llega a una clase

Un alumno puede estar inscripto a un `MateriaDictado` de dos formas (UNION en la vista):
1. **Individual:** `mxm_alumnos_materias` apunta directo al dictado.
2. **Grupal:** El curso del alumno (`id_curso_actual` o `id_grupo_taller_actual`) está en `mxm_cursos_materias_dictado`.




# Resumen General del Proyecto

## Visión General

El proyecto consiste en un sistema integral de gestión escolar tipo ERP, orientado inicialmente a instituciones educativas de nivel secundario técnico, pero diseñado desde el principio con una arquitectura flexible, modular y adaptable a distintos modelos institucionales.

El objetivo principal del sistema es centralizar, digitalizar y organizar los distintos procesos administrativos, académicos y pedagógicos que ocurren dentro de un colegio, permitiendo que múltiples departamentos trabajen de forma coordinada sobre una única fuente de información.

El sistema busca reemplazar procesos manuales, planillas físicas y registros fragmentados, ofreciendo trazabilidad, consistencia de datos y automatización de tareas críticas como asistencia, calificaciones, historial académico y seguimiento institucional.

Aunque actualmente el proyecto nace desde las necesidades concretas de un colegio técnico, toda la arquitectura fue pensada para permitir adaptaciones futuras a otras instituciones con distintos modelos organizativos, pedagógicos o administrativos.

## Filosofía de Diseño del Sistema

### Arquitectura Modular y Flexible

Uno de los principios fundamentales del proyecto es que el sistema debe poder adaptarse a distintos contextos institucionales sin necesidad de rediseñar completamente la base de datos o la lógica de negocio.

Por este motivo, el sistema intenta evitar relaciones rígidas o excesivamente acopladas entre entidades.

Muchos procesos fueron diseñados utilizando modelos de asignación dinámicos y relaciones intermedias, permitiendo que una misma operación pueda originarse desde distintas entidades o caminos lógicos.

### Ejemplo conceptual

**Un alumno puede quedar asociado a una materia de distintas formas:**

- Mediante la asignación de su curso completo.
- Mediante una inscripción individual.
- Mediante grupos especiales o estructuras futuras (intensificación, talleres, agrupamientos temporales, etc.).

Aunque existan múltiples caminos para llegar a esa relación, el sistema busca siempre consolidar el resultado final en estructuras simples y consistentes, permitiendo mantener una única fuente de verdad para cada operación.

**Este enfoque permite:**

- Escalabilidad futura.
- Adaptación a distintos modelos educativos.
- Menor duplicación lógica.
- Procesos reutilizables.
- Mayor facilidad de mantenimiento.

## Objetivo General del ERP

El sistema está pensado para abarcar progresivamente todos los departamentos y procesos relevantes dentro de una institución educativa.

No se limita únicamente al registro académico, sino que apunta a convertirse en una plataforma centralizada para la gestión institucional completa.

Actualmente, los módulos principales identificados son:

- Dirección
- Secretaría
- Preceptoría
- Orientación
- Docentes
- Alumnos

En el futuro podrían agregarse nuevos módulos según las necesidades de cada institución.

## Diferencia entre Departamentos y Módulos

Dentro del proyecto existen dos conceptos importantes:

### Departamentos físicos/institucionales

Representan áreas reales existentes dentro del colegio.

Ejemplos:

- Dirección
- Secretaría
- Preceptoría
- Orientación

Son estructuras organizativas humanas reales.

### Módulos del sistema

Representan entidades lógicas o funcionales dentro del software.

Ejemplos:

- Módulo Docentes
- Módulo Alumnos
- Módulo Asistencias
- Módulo Históricos

Un módulo puede interactuar con múltiples departamentos al mismo tiempo.

## Departamentos Institucionales

### Dirección

Dirección representa la entidad administrativa central del sistema.

Es el área responsable de supervisar, validar y administrar la mayoría de los procesos institucionales.

Desde dirección se gestionan:

- Altas y bajas de alumnos.
- Cambios de curso.
- Administración general de entidades.
- Eventos institucionales.
- Validación administrativa.
- Auditoría de información.
- Gestión académica general.
- Generación y validación de boletines.
- Comunicación con organismos externos.
- Información requerida por entes provinciales o educativos.

Dirección funciona como el núcleo administrativo del sistema.

### Secretaría

Secretaría funciona como un subárea operativa dentro de dirección.

Se encarga de ejecutar muchas de las tareas administrativas cotidianas necesarias para el funcionamiento institucional.

Aunque depende organizativamente de dirección, requiere herramientas y procesos propios dentro del sistema.

### Preceptoría

Preceptoría es el área encargada del seguimiento cotidiano de los alumnos y de la organización operativa de los cursos.

Actúa como nexo entre:

- alumnos,
- docentes,
- cursos,
- y dirección.

Sus responsabilidades incluyen:

- Control de asistencia.
- Seguimiento de inasistencias.
- Registro de retiros.
- Supervisión cotidiana de cursos.
- Intervención ante conflictos o situaciones particulares.
- Comunicación con docentes.
- Coordinación operativa institucional.

Preceptoría también administra uno de los elementos centrales del sistema académico:

#### Libro de Temas

El libro de temas es un registro institucional obligatorio donde cada docente deja constancia de:

- Temas vistos en clase.
- Actividades realizadas.
- Observaciones generales.
- Incidentes o situaciones particulares.
- Asistencia de alumnos.

Cada registro corresponde a:

- una fecha,
- un curso,
- una materia,
- y un docente.

El libro de temas constituye uno de los núcleos funcionales más importantes del sistema actual.

### Orientación

Orientación es el departamento encargado del acompañamiento emocional, psicológico y social de los alumnos.

Su función principal es realizar seguimiento de situaciones particulares que puedan afectar el desempeño o bienestar de los estudiantes.

Entre sus funciones se incluyen:

- Seguimiento individual de alumnos.
- Elaboración de informes.
- Comunicación con docentes.
- Acompañamiento institucional.
- Observaciones pedagógicas y sociales.

Una de sus tareas más importantes es generar informes institucionales sobre situaciones particulares de alumnos para que los docentes puedan tener contexto al momento de trabajar con cada curso.

Este módulo todavía no se encuentra desarrollado completamente, pero forma parte importante de la visión futura del sistema.

## Módulos Principales del Sistema

### Módulo Docentes

Es actualmente el módulo más avanzado y desarrollado del sistema.

Fue diseñado para centralizar todas las herramientas que el docente necesita durante el dictado de clases.

Entre sus funciones principales se encuentran:

- Tomar asistencia.
- Completar libro de temas.
- Registrar observaciones.
- Cargar calificaciones.
- Crear trabajos prácticos.
- Gestionar evaluaciones.
- Consultar cursos y materias asignadas.
- Exportar información.

El módulo docente interactúa directamente con:

- preceptoría,
- alumnos,
- calificaciones,
- y registros históricos.
- Módulo Alumnos

El alumno representa una de las entidades centrales y transversales del sistema.

Toda la información institucional gira alrededor del recorrido académico y administrativo del alumno.

El módulo alumnos concentra:

- Datos personales.
- Estado académico.
- Asistencias.
- Calificaciones.
- Observaciones.
- Historial institucional.
- Relaciones con cursos y materias.

La entidad alumno atraviesa prácticamente todos los módulos del sistema.

### Sistema Histórico (Libro Matriz)

Uno de los componentes más importantes planificados para el sistema es el módulo histórico.

Este módulo funciona como una capa permanente e inmutable de información académica.

Está inspirado en el concepto institucional real conocido como “Libro Matriz”.

#### Objetivo

Preservar el historial completo del recorrido académico del alumno independientemente de cambios futuros en la base de datos principal.

Esto es especialmente importante porque:

- los boletines tienen validez institucional,
- existen implicancias administrativas y legales,
- y se necesita trazabilidad histórica confiable.

#### Información Histórica

El sistema histórico almacenará:

- Historial académico
    - Materias cursadas.
    - Año lectivo.
    - Curso correspondiente.
    - Docente asignado.
    - Plan de estudio.
    - Calificaciones finales.
    - Observaciones.
- Historial institucional
    - Cambios de curso.
    - Recorridos académicos.
    - Situaciones administrativas.
- Historial de asistencias
    - Registro de asistencia histórica.
    - Seguimiento de presencialidad.
    - Estadísticas de concurrencia.

#### Importancia crítica

El módulo histórico es considerado uno de los componentes más críticos del sistema debido a:

- Su importancia institucional.
- Necesidades de auditoría.
- Requerimientos administrativos.
- Generación de boletines.
- Persistencia histórica de datos académicos.

La información histórica debe poder sobrevivir incluso ante:

- cambios estructurales,
- modificaciones futuras,
- o migraciones del sistema principal.

Por este motivo, el diseño del histórico tendrá especial prioridad en términos de integridad y consistencia de datos.