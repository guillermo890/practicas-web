# PRÁCTICA 2. CRUD DE USUARIOS CON PERMISOS SEGÚN EL ROL

## 1. Objetivo

Desarrollar un módulo de administración de usuarios en Laravel que permita registrar, consultar, modificar y eliminar usuarios, aplicando permisos diferentes según el rol de cada usuario.

## 2. Descripción de la práctica

Se desarrolló un sistema de administración de usuarios con dos roles principales:

- **Administrador:** tiene acceso completo a las operaciones CRUD, puede eliminar usuarios temporalmente, recuperar registros y eliminarlos definitivamente.
- **Empleado:** puede registrar, consultar y modificar usuarios, pero no tiene permiso para eliminarlos ni acceder a la sección de usuarios eliminados.

El sistema utiliza Laravel, Eloquent ORM, middleware y vistas Blade para controlar las operaciones y mostrar la información.

## 3. Funcionalidades desarrolladas

### 3.1 Registro de usuarios

Permite registrar nuevos usuarios mediante un formulario que solicita:

- Nombre completo.
- Correo electrónico.
- Contraseña.
- Rol.

El sistema valida que el correo electrónico no esté registrado anteriormente y que los datos obligatorios sean correctos.

### 3.2 Consulta de usuarios

Muestra una tabla con los usuarios registrados, incluyendo:

- ID.
- Nombre.
- Correo electrónico.
- Rol.
- Acciones disponibles.

También permite consultar la información individual de cada usuario.

### 3.3 Edición de usuarios

Permite modificar el nombre, correo electrónico, contraseña y rol de un usuario.

La contraseña es opcional durante la edición. Si se deja vacía, se conserva la contraseña anterior.

### 3.4 Eliminación temporal

El administrador puede eliminar temporalmente un usuario. El registro deja de aparecer en la lista principal, pero permanece almacenado en la base de datos mediante Soft Deletes.

### 3.5 Recuperación de usuarios

El administrador puede consultar los usuarios eliminados temporalmente y restaurarlos para que vuelvan a aparecer en la lista principal.

### 3.6 Eliminación permanente

El administrador puede eliminar definitivamente un usuario que se encuentre en la sección de eliminados. Esta operación no permite recuperar posteriormente el registro.

## 4. Control de permisos

Se implementó un middleware para restringir el acceso a las operaciones según el rol del usuario autenticado.

| Operación | Administrador | Empleado |
|---|---|---|
| Registrar usuarios | Sí | Sí |
| Consultar usuarios | Sí | Sí |
| Editar usuarios | Sí | Sí |
| Eliminar temporalmente | Sí | No |
| Recuperar usuarios | Sí | No |
| Eliminar definitivamente | Sí | No |
| Consultar usuarios eliminados | Sí | No |

Además, el empleado solamente puede asignar el rol de Empleado al registrar o modificar usuarios.

## 5. Validaciones y seguridad

Se implementaron las siguientes medidas:

- Validación de campos obligatorios.
- Validación del formato del correo electrónico.
- Comprobación de que el correo sea único.
- Contraseñas con un mínimo de ocho caracteres.
- Almacenamiento de contraseñas mediante hash.
- Validación de roles existentes.
- Protección de rutas mediante middleware.
- Protección de formularios mediante tokens CSRF.
- Restricción de eliminación para empleados.
- Protección contra la eliminación de la propia cuenta del administrador.
- Uso de Soft Deletes para recuperar usuarios eliminados.

## 6. Archivos principales desarrollados

**Controlador:**
- `app/Http/Controllers/UsuarioController.php`

**Modelo:**
- `app/Models/User.php`

**Middleware:**
- `app/Http/Middleware/VerificarRol.php`

**Vistas:**
- `resources/views/practica2/usuarios/index.blade.php`
- `resources/views/practica2/usuarios/create.blade.php`
- `resources/views/practica2/usuarios/show.blade.php`
- `resources/views/practica2/usuarios/edit.blade.php`
- `resources/views/practica2/usuarios/eliminados.blade.php`

**Rutas:**
- `routes/web.php`

**Migración:**
- Migración para agregar `deleted_at` a la tabla `users`.

## 7. Pruebas realizadas

| Prueba | Resultado |
|---|---|
| Acceso a la administración de usuarios | Correcto |
| Registro de un usuario | Correcto |
| Consulta de usuarios | Correcto |
| Edición de usuarios | Correcto |
| Eliminación temporal | Correcto |
| Recuperación de usuarios | Correcto |
| Eliminación permanente | Correcto |
| Acceso de empleado a la administración | Correcto |
| Restricción de eliminación para empleado | Correcto |
| Restricción de acceso a usuarios eliminados | Correcto |

## 8. Evidencias

Agregar las siguientes capturas de pantalla:

1. Pantalla principal de administración de usuarios.
2. Formulario de registro de usuarios.
3. Usuario registrado en la tabla.
4. Formulario de edición.
5. Pantalla de usuarios eliminados.
6. Usuario recuperado en la tabla principal.
7. Confirmación de eliminación permanente.
8. Administración de usuarios con sesión de empleado.
9. Restricción de permisos para el empleado.

## 9. Conclusión

En esta práctica se desarrolló un módulo de administración de usuarios utilizando Laravel, aplicando operaciones CRUD y permisos según el rol de cada usuario.

Se comprobó el funcionamiento del registro, consulta, edición, eliminación temporal, recuperación y eliminación permanente. También se verificó que los empleados puedan realizar las operaciones permitidas sin tener acceso a las funciones exclusivas del administrador.

Con este módulo se aplicaron conocimientos de modelos, controladores, migraciones, vistas Blade, validaciones, middleware y relaciones entre tablas.
