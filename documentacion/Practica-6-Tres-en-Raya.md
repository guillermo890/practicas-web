# Práctica 1.6: Juego del gato (Tic-Tac-Toe)

## 1. Descripción general

Se desarrolló un sistema multijugador del juego del gato utilizando Laravel, PHP, SQLite y Tailwind CSS.

El sistema permite que dos usuarios con el rol de Jugador participen en una partida desde sesiones independientes, compartiendo el mismo tablero y respetando los turnos correspondientes.

## 2. Objetivo

Implementar un sistema multijugador que permita comprender el manejo de sesiones independientes, autenticación, autorización mediante roles, persistencia de información y sincronización de datos entre múltiples usuarios.

## 3. Tecnologías utilizadas

- Laravel 13.43.0
- PHP 8.5.0
- SQLite
- Blade
- Tailwind CSS
- JavaScript
- Eloquent ORM

## 4. Funcionalidades implementadas

### 4.1 Usuarios y autenticación

- Inicio de sesión para usuarios.
- Acceso mediante el rol Jugador.
- Validación de permisos.
- Sesiones independientes para cada usuario.

### 4.2 Gestión de partidas

- Crear nuevas partidas.
- Consultar partidas disponibles.
- Permitir que otro jugador se una.
- Asignar automáticamente los símbolos X y O.
- Consultar el historial de partidas.

### 4.3 Desarrollo del juego

- Tablero de nueve casillas.
- Alternancia de turnos.
- Validación de casillas ocupadas.
- Detección de ganador.
- Detección de empate.
- Cancelación de partidas.

### 4.4 Sincronización

Se implementó una actualización automática mediante consultas periódicas con JavaScript (Polling).

Esto permite que los dos jugadores visualicen los cambios del tablero sin tener que actualizar manualmente la página.

También se agregó un control de