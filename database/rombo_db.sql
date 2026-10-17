CREATE DATABASE IF NOT EXISTS `rombo_db`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `rombo_db`;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS `usuario` (
    `id_usuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL DEFAULT '',
    `correo` VARCHAR(255) NOT NULL,
    `clave` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_usuario`),
    UNIQUE KEY `uq_usuario_correo` (`correo`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

-- Tabla de rombos
CREATE TABLE IF NOT EXISTS `rombo` (
    `id_rombo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `detalle` TEXT NULL,
    `diagonal_mayor` DOUBLE NOT NULL,
    `diagonal_menor` DOUBLE NOT NULL,
    `lado` DOUBLE NOT NULL,
    `area` DOUBLE NOT NULL,
    `perimetro` DOUBLE NOT NULL,
    `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_rombo`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

-- Usuario administrador inicial
INSERT INTO `usuario` (`nombre`, `correo`, `clave`)
SELECT 'Administrador', 'admin@rombo', '123'
WHERE NOT EXISTS (
    SELECT 1
    FROM `usuario`
    WHERE `correo` = 'admin@rombo'
);