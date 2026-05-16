# Sistema de Gestión ITLP

![Logo del Sistema de Gestión ITLP](<./public/icons/ITLP_LOGO.png>)

## Descripción

Sistema integral de gestión escolar tipo ERP orientado a instituciones educativas de nivel secundario técnico. Centraliza los procesos administrativos, académicos y pedagógicos de un colegio en una única plataforma.

## Stack

- **Laravel 12** — PHP 8.2+
- **Livewire 3** — UI reactiva sin SPA
- **Tailwind CSS 4** — via Vite
- **MariaDB/MySQL** (`sgitlp`) — base de datos principal
- **PHPSpreadsheet** — exportación Excel

## Requisitos

- PHP 8.2+
- Composer
- Node.js + npm
- MariaDB o MySQL

## Instalación

```bash
# Clonar el repositorio
git clone <url-del-repo>
cd sistema-administracion-itlp

# Instalar dependencias PHP y JS
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate
```

Configurar la conexión a la base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sgitlp
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contrasenia
```

> La base de datos debe existir previamente e importarse desde el dump SQL del proyecto. Los timestamps y las vistas SQL se gestionan directamente en la BD mediante triggers y DDL — no se usan migraciones de Laravel.

## Levantar el proyecto para desarrollo

El comando `composer run dev` levanta todos los procesos necesarios en paralelo en una sola terminal:

```bash
composer run dev
```

Esto inicia simultáneamente:
- Servidor PHP (`php artisan serve`) → [http://localhost:8000](http://localhost:8000)
- Worker de colas (`php artisan queue:work`)
- Log en tiempo real (`php artisan pail`)
- Vite para assets (`npm run dev`)

Si preferís levantar cada proceso por separado:

```bash
php artisan serve       # servidor PHP
npm run dev             # compilación de assets con hot reload
```

> Asegurate de tener la BD importada y el `.env` configurado antes de levantar el servidor.


## Comandos frecuentes

```bash
# Desarrollo (servidor + queue + logs + Vite en paralelo)
composer run dev

# Solo servidor PHP
php artisan serve

# Solo frontend
npm run dev

# Linting
./vendor/bin/pint

# Tests
composer run test
```

## Arquitectura

El proyecto sigue una arquitectura monolítica por capas:

```
HTTP Request → Form Request → Controller → Action → Modelo
                                    ↓
                               Vista SQL (lectura)
```

| Capa | Ubicación | Responsabilidad |
|------|-----------|----------------|
| Form Requests | `app/Http/Requests/` | Validación de entrada |
| Controllers | `app/Http/Controllers/` | Coordinación: llama la Action, devuelve respuesta HTTP |
| Actions | `app/Actions/` | Lógica de escritura (insert, update, sincronización) |
| Vistas SQL | Base de datos | Lectura con joins complejos, sin armar queries en PHP |
| Modelos | `app/Models/` | Estructura, relaciones, insert/update |
| Livewire | `app/Livewire/` | Tablas interactivas con filtros y paginación |

## Módulos implementados

- **Docentes** — libro de temas, tomar lista, trabajos prácticos, exportación Excel
- **Administración** — CRUD de alumnos, docentes, cursos, materias, años lectivos



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