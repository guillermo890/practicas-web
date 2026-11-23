# Práctica 3. Sistema de información académica

## Objetivo

Desarrollar un sistema de información académica que permita administrar los registros de los alumnos, controlar sus faltas y calificaciones, y mostrar automáticamente la equivalencia alfabética correspondiente. También se implementan permisos de acceso dependiendo del rol del usuario.

## Desarrollo

Se creó un módulo académico utilizando Laravel, PHP, Blade y SQLite.

El sistema cuenta con las siguientes funciones:

1. Registrar alumnos y relacionarlos con una cuenta de usuario.
2. Consultar los registros académicos.
3. Modificar el nombre, las faltas y las calificaciones.
4. Eliminar registros académicos.
5. Ordenar los registros por nombre, calificación y número de faltas.
6. Mostrar automáticamente la equivalencia alfabética de cada calificación.
7. Permitir que cada alumno consulte únicamente su propia información académica.

## Equivalencias de calificaciones

| Calificación | Equivalencia |
|---|---|
| 0 a 69 | NA |
| 70 a 79 | SA |
| 80 a 89 | DE |
| 90 a 100 | AU |

## Control de acceso

- **Profesor:** puede registrar, consultar, modificar y eliminar registros académicos.
- **Alumno:** solamente puede consultar su propia información académica.
- Los permisos se controlan mediante middleware y rutas protegidas.

## Validaciones

- El nombre del alumno es obligatorio.
- Las faltas deben ser números enteros mayores o iguales a cero.
- La calificación debe ser numérica y estar entre 0 y 100.
- Cada cuenta de alumno puede tener un solo registro académico.

## Pruebas realizadas

Se comprobó el funcionamiento del registro, consulta, edición y eliminación de alumnos. También se verificó el cálculo automático de equivalencias, el ordenamiento de registros y las restricciones de acceso según el rol.

**Resultado:** Las pruebas realizadas funcionaron correctamente.

## Evidencias

Agregar las capturas de pantalla de:

1. Lista de alumnos.
2. Formulario de registro académico.
3. Edición de un registro.
4. Consulta de información como alumno.
5. Resultado de las equivalencias de calificaciones.
6. Restricción de acceso por roles.