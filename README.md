# Sistema del rombo

Aplicación web en PHP y MySQL para calcular y guardar el lado, el área y el
perímetro de un rombo a partir de sus diagonales. Incluye inicio de sesión
y un CRUD completo (guardar, buscar, editar y eliminar).

## Tecnologías

- PHP 8 con PDO
- MySQL (XAMPP)
- HTML, CSS y JavaScript

## Fórmulas

- Área = (D × d) / 2
- Lado = √((D/2)² + (d/2)²)
- Perímetro = 4 × lado


## Instalación

1. Inicia Apache y MySQL en XAMPP.
2. En MySQL Workbench o phpMyAdmin, ejecuta `database/rombo_db.sql`.
3. Revisa `config/Database.php` (host `127.0.0.1`, puerto `3306`, usuario `root`).
4. Desde la carpeta del proyecto, inicia el servidor:

```
php -S 127.0.0.1:8000
```

5. Abre `http://127.0.0.1:8000/views/login.php`.

## Acceso de prueba

- Correo: `admin@rombo`
- Clave: `123`