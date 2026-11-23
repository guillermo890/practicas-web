
# Práctica 1. Autenticación basada en roles

## 1. Objetivo

Implementar un sistema de autenticación que permita controlar el acceso de los usuarios mediante correo electrónico, contraseña y roles.

## 2. Descripción

El sistema cuenta con dos tipos de acceso implementados:

- Administrador: inicia sesión con correo y contraseña y posteriormente recibe un código de verificación de seis dígitos en su correo electrónico.
- Empleado: tendrá acceso mediante correo y contraseña, sin verificación adicional.

## 3. Funcionamiento del administrador

1. Ingresa su correo electrónico y contraseña.
2. El sistema comprueba sus credenciales.
3. Genera un código aleatorio de seis dígitos.
4. Envía el código al correo registrado.
5. El código tiene una vigencia de cinco minutos.
6. El administrador introduce el código.
7. Si es correcto, puede acceder al panel principal.

Se estableció un máximo de cinco intentos para introducir el código.

## 4. Seguridad implementada

- Contraseñas almacenadas mediante hash.
- Código de verificación almacenado mediante hash en la sesión.
- Protección de las rutas de verificación mediante middleware.
- Regeneración del identificador de sesión al iniciar sesión.
- Invalidación de sesión al cerrar sesión.
- Límite de intentos de verificación.

## 5. Archivos desarrollados

- app/Http/Controllers/AuthController.php
- app/Http/Middleware/VerificarRol.php
- app/Http/Middleware/VerificarCodigoPendiente.php
- bootstrap/app.php
- routes/web.php
- resources/views/auth/login.blade.php
- resources/views/auth/verificar.blade.php
- resources/views/inicio.blade.php

## 6. Pruebas realizadas

- Se comprobó que las rutas de autenticación aparecen correctamente.
- Se verificó que el formulario de inicio de sesión se muestra correctamente.
- Se comprobó el envío del código al correo del administrador.
- Se introdujo el código recibido y se consiguió acceder al panel principal.

## 7. Evidencias

Agregar capturas de pantalla de:

1. Formulario de inicio de sesión.
2. Correo electrónico con el código recibido.
3. Formulario de verificación.
4. Panel principal después de iniciar sesión.

## 8. Estado de la práctica

La autenticación del administrador fue probada correctamente. El acceso del empleado y las pruebas de intentos y expiración quedan pendientes de comprobación.
