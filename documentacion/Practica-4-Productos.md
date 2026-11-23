# Práctica 4. Administración de productos

## 1. Objetivo

Desarrollar un módulo web para la administración de productos utilizando Laravel, que permita registrar, consultar, editar y eliminar productos, además de realizar búsquedas, filtros y ordenamientos. El sistema utiliza permisos según el rol del usuario para proteger las operaciones.

## 2. Descripción general

La práctica consiste en implementar un sistema de administración de productos relacionado con un catálogo de categorías.

Cada producto contiene los siguientes datos:

- Identificador.
- Nombre.
- Descripción.
- Categoría.
- Precio.
- Stock.
- Estado.
- Fecha de registro.

El sistema permite que los usuarios con rol de Administrador administren los productos, mientras que los usuarios con rol de Empleado solamente pueden consultarlos.

## 3. Funcionalidades implementadas

### 3.1 Administración de categorías

- Registrar categorías.
- Consultar las categorías registradas.
- Eliminar categorías que no tengan productos relacionados.
- Evitar la eliminación de categorías que tengan productos asociados.

### 3.2 Registro de productos

El Administrador puede registrar productos proporcionando su nombre, descripción, categoría, precio, stock y estado.

La fecha de registro se establece automáticamente.

### 3.3 Consulta de productos

El sistema muestra un listado de productos con su información principal:

- Nombre.
- Categoría.
- Precio.
- Stock.
- Estado.
- Fecha de registro.

También permite consultar los detalles individuales de cada producto.

### 3.4 Edición y eliminación

El Administrador puede modificar los datos de los productos y eliminarlos del sistema.

La edición permite conservar el nombre del producto actual sin generar errores de duplicidad.

### 3.5 Búsqueda y filtros

Se implementaron filtros por:

- Nombre.
- Categoría.
- Estado.
- Precio mínimo.
- Precio máximo.

Los filtros pueden utilizarse de manera combinada y pueden limpiarse para volver a mostrar todos los productos.

### 3.6 Ordenamiento

El listado permite ordenar los productos por:

- Nombre de A a Z.
- Nombre de Z a A.
- Precio ascendente.
- Precio descendente.
- Stock ascendente.
- Stock descendente.
- Fecha más reciente.
- Fecha más antigua.

### 3.7 Paginación

Se implementó paginación con las siguientes opciones:

- 10 registros.
- 15 registros.
- 25 registros.
- 50 registros.

También se conserva la búsqueda y los filtros al cambiar de página.

## 4. Validaciones

Se implementaron validaciones mediante `ProductoRequest`.

| Campo | Validación |
|---|---|
| Nombre | Obligatorio, texto y único |
| Descripción | Obligatoria |
| Categoría | Debe existir en el catálogo |
| Precio | Numérico y mayor que cero |
| Stock | Número entero y no negativo |
| Estado | Disponible o Agotado |

También se agregaron mensajes personalizados para informar al usuario cuando los datos no cumplen las condiciones establecidas.

## 5. Seguridad y permisos

El sistema utiliza middleware para controlar el acceso según el rol.

**Administrador:**
- Consultar productos.
- Registrar productos.
- Editar productos.
- Eliminar productos.
- Administrar categorías.

**Empleado:**
- Consultar productos.
- Buscar productos.
- Aplicar filtros.
- Ordenar resultados.

El Empleado no puede registrar, editar ni eliminar productos. Las rutas de administración están protegidas desde el servidor mediante middleware.

## 6. Tecnologías utilizadas

- Laravel 13.43.0.
- PHP 8.5.0.
- SQLite.
- Blade.
- Tailwind CSS.
- Eloquent ORM.
- Form Requests.
- Middleware.
- Componentes Blade.

## 7. Archivos principales del desarrollo

- `ProductoController.php`: administra las operaciones de productos.
- `CategoriaController.php`: administra las categorías.
- `Producto.php`: modelo de productos.
- `Categoria.php`: modelo de categorías.
- `ProductoRequest.php`: contiene las validaciones.
- `Alerta.php`: clase del componente reutilizable de alertas.
- `alerta.blade.php`: diseño del componente