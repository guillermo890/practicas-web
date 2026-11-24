# Práctica 1.5: Sistema de reservación de equipos de cómputo

## 1. Objetivo

Comprender e implementar el manejo de sesiones independientes en Laravel, permitiendo el acceso simultáneo de múltiples usuarios desde diferentes equipos, garantizando la privacidad de la información y la integridad de las operaciones realizadas en el servidor.

## 2. Descripción del sistema

Se desarrolló un sistema de reservación de equipos de cómputo utilizando Laravel, en el cual los usuarios pueden iniciar sesión y realizar diferentes operaciones dependiendo de su rol.

El sistema cuenta con dos roles principales:

- **Administrador:** puede registrar, consultar, actualizar y eliminar equipos, además de consultar y cancelar reservaciones.
- **Estudiante:** puede consultar equipos disponibles, realizar reservaciones, consultar sus propias reservaciones y cancelar aquellas que continúen activas.

## 3. Tecnologías utilizadas

- Laravel.
- PHP.
- SQLite.
- Eloquent ORM.
- Blade.
- Tailwind CSS.
- Middleware de Laravel.

## 4. Funcionalidades implementadas

1. Inicio de sesión para diferentes usuarios.
2. Manejo de sesiones independientes.
3. Consulta de equipos disponibles.
4. Registro, actualización y eliminación de equipos.
5. Realización de reservaciones.
6. Validación de fechas y horarios.
7. Prevención de reservaciones duplicadas.
8. Consulta de reservaciones propias.
9. Cancelación de reservaciones.
10. Administración de todas las reservaciones.
11. Protección de información privada mediante autenticación y roles.
12. Cierre de sesión independiente.

## 5. Manejo de sesiones

Se configuró el almacenamiento de sesiones mediante la base de datos, con un tiempo de expiración de 120 minutos por inactividad.

También se implementaron las siguientes medidas:

- Regeneración del identificador de sesión después del inicio de sesión.
- Invalidación de la sesión al cerrar sesión.
- Regeneración del token CSRF.
- Protección de las reservaciones para evitar que un estudiante consulte información de otro usuario.

## 6. Pruebas realizadas

Se realizaron pruebas utilizando dos sesiones independientes con usuarios diferentes.

| Prueba | Resultado |
|---|---|
| Inicio de sesión de dos usuarios | Correcto |
| Sesiones independientes | Correcto |
| Registro de reservación | Correcto |
| Evitar reservaciones en horarios ocupados | Correcto |
| Cierre de sesión independiente | Correcto |
| Protección de reservaciones privadas | Correcto |

## 7. Evidencias

En este apartado se agregarán las capturas de pantalla del funcionamiento del sistema y de las pruebas realizadas.

## 8. Conclusión

Con esta práctica se implementó un sistema de reservación de equipos de cómputo utilizando Laravel. Se trabajó con autenticación, sesiones independientes, roles, relaciones entre modelos y validaciones para proteger las operaciones.

Además, se comprobó que diferentes usuarios pueden utilizar el sistema simultáneamente, que las sesiones son independientes y que un estudiante no puede acceder a las reservaciones privadas de otro usuario.

## 9. Código fuente