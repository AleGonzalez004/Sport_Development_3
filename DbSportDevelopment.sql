DROP DATABASE IF EXISTS sport;
CREATE DATABASE sport;
USE sport;

CREATE TABLE tb_administradores (
 id_admin INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
 nombre VARCHAR(50) NOT NULL,
 apellido VARCHAR(50) NOT NULL,
 correo_administrador VARCHAR(100) NOT NULL,
 alias_administrador VARCHAR(25) NOT NULL,
 clave_administrador VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_clientes (
  id_cliente INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  nombre_cliente VARCHAR(50) NOT NULL,
  apellido_cliente VARCHAR(50) NOT NULL,
  dui_cliente VARCHAR(10) NOT NULL,
  correo_cliente VARCHAR(100) NOT NULL,
  telefono_cliente VARCHAR(9) NOT NULL,
  direccion_cliente VARCHAR(250) NOT NULL,
  nacimiento_cliente DATE NOT NULL,
  clave_cliente VARCHAR(100) NOT NULL,
  estado_cliente TINYINT(1) NOT NULL DEFAULT 1,
  fecha_registro DATE NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_tallas (
   id_talla INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   nombre VARCHAR(5) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_categorias (
  id_categoria INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  nombre VARCHAR(50) NOT NULL,
  descripcion VARCHAR(250) DEFAULT NULL,
  imagen VARCHAR(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_productos(
  id_producto INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  nombre_producto VARCHAR(50) NOT NULL,
  descripcion_producto VARCHAR(250) NOT NULL,
  precio_producto DECIMAL(5,2) NOT NULL,
  existencias_producto INT(10) UNSIGNED NOT NULL,
  imagen_producto VARCHAR(25) NOT NULL,
  id_categoria INT(10) UNSIGNED NOT NULL,
  estado_producto TINYINT(1) NOT NULL,
  id_administrador INT(10) UNSIGNED NOT NULL,
  fecha_registro DATE NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_detalle_pedidos (
  id_detalle INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  id_producto INT(10) UNSIGNED NOT NULL,
  cantidad_producto SMALLINT(6) UNSIGNED NOT NULL,
  precio_producto DECIMAL(5,2) UNSIGNED NOT NULL,
  calificacion_producto ENUM ('1', '2', '3', '4', '5') NOT NULL,
  comentario_producto VARCHAR(255) NOT NULL,
  fecha_valoracion DATE NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  estado_comentario BOOLEAN NOT NULL,
  id_pedido INT(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_pedidos (
  id_pedido INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  id_cliente INT(10) UNSIGNED NOT NULL,
  direccion_pedido VARCHAR(250) NOT NULL,
  estado_pedido ENUM('Pendiente','EnCamino','Entregado','Cancelado','Historial') NOT NULL,
  fecha_registro DATE NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_colores (
 id_color INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
 nombre VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_marcas (
   id_marca INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   nombre VARCHAR(20) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_deportes (
   id_deporte INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   nombre VARCHAR(20) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_generos (
   id_genero INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   nombre VARCHAR(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_imagenes (
   id_imagen INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   nombre_imagen VARCHAR(25) NOT NULL,
   id_producto INT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_targetas (
   id_targeta INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   tipo_targeta ENUM('Visa','MasterCard') NOT NULL,
   tipo_uso ENUM('Credito','Debito') NOT NULL,
   numero_targeta INT(16) UNSIGNED NOT NULL,
   nombre_targeta VARCHAR(50) NOT NULL,
   fecha_expiracion INT(5) UNSIGNED NOT NULL,
   codigo_verificacion INT(5) UNSIGNED NOT NULL,
   id_cliente INT(10) UNSIGNED NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO tb_clientes (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, direccion_cliente, nacimiento_cliente, clave_cliente, estado_cliente, fecha_registro) VALUES
('Juan', 'Pérez', '12345678-9', 'juan.perez@example.com', '123456789', 'Av. Siempre Viva 742', '1980-01-01', 'clave123', 1, '2014-01-20'),
('Ana', 'García', '98765432-1', 'ana.garcia@example.com', '987654321', 'Calle Falsa 123', '1990-05-15', 'clave456', 1, '2024-07-11'),
('Luis', 'Martínez', '23456789-0', 'luis.martinez@example.com', '234567890', 'Boulevard de los Sueños 456', '1985-09-10', 'clave789', 1, '2024-07-12'),
('María', 'Rodríguez', '87654321-0', 'maria.rodriguez@example.com', '876543210', 'Avenida de la Libertad 789', '1992-12-25', 'clave321', 1, '2024-07-13'),
('Carlos', 'Hernández', '34567890-1', 'carlos.hernandez@example.com', '345678901', 'Plaza Central 101', '1988-07-22', 'clave654', 1, '2024-07-15'),
('Sofía', 'López', '12398765-4', 'sofia.lopez@example.com', '123987654', 'Pasaje del Sol 111', '1993-03-05', 'clave852', 1, '2024-07-15'),
('Diego', 'Torres', '98712365-4', 'diego.torres@example.com', '987123654', 'Calle Luna 222', '1987-11-23', 'clave951', 1, '2024-07-16'),
('Lucía', 'Méndez', '32165498-7', 'lucia.mendez@example.com', '321654987', 'Av. de las Rosas 333', '1994-06-18', 'clave753', 1, '2024-07-15'),
('Pedro', 'Morales', '78932145-6', 'pedro.morales@example.com', '789321456', 'Calle el Sol 444', '1989-08-30', 'clave159', 1, '2024-07-18'),
('Clara', 'Ríos', '45698732-1', 'clara.rios@example.com', '456987321', 'Boulevard Estrella 555', '1991-12-14', 'clave357', 1, '2024-07-19');

INSERT INTO tb_pedidos (id_cliente, direccion_pedido, estado_pedido, fecha_registro) VALUES
(1, 'Av. Siempre Viva 742', 'Cancelado', '2024-07-01'),
(1, 'Av. Siempre Viva 742', 'EnCamino', '2024-07-02'),
(1, 'Av. Siempre Viva 742', 'EnCamino', '2024-07-03'),
(2, 'Calle Falsa 123', 'Entregado', '2024-07-04'),
(3, 'Boulevard de los Sueños 456', 'Pendiente', '2024-07-05'),
(4, 'Avenida de la Libertad 789', 'Entregado', '2024-07-06'),
(4, 'Avenida de la Libertad 789', 'EnCamino', '2024-07-07'),
(4, 'Avenida de la Libertad 789', 'Cancelado', '2024-07-08'),
(5, 'Plaza Central 101', 'Entregado', '2024-07-09'),
(5, 'Plaza Central 101', 'Entregado', '2024-07-10'),
(6, 'Pasaje del Sol 111', 'Entregado', '2024-07-11'),
(7, 'Calle Luna 222', 'Entregado', '2024-07-12'),
(8, 'Av. de las Rosas 333', 'Entregado', '2024-07-15'),
(9, 'Calle el Sol 444', 'Entregado', '2024-07-15'),
(10, 'Boulevard Estrella 555', 'Entregado', '2024-07-15'),
(2, 'Calle Falsa 123', 'Pendiente', '2024-07-16'),
(3, 'Boulevard de los Sueños 456', 'Cancelado', '2024-07-17'),
(4, 'Avenida de la Libertad 789', 'EnCamino', '2024-07-18'),
(5, 'Plaza Central 101', 'Pendiente', '2024-07-19'),
(6, 'Pasaje del Sol 111', 'Cancelado', '2024-07-20'),
(7, 'Calle Luna 222', 'Pendiente', '2024-07-21'),
(8, 'Av. de las Rosas 333', 'Pendiente', '2024-07-22'),
(9, 'Calle el Sol 444', 'EnCamino', '2024-07-23'),
(10, 'Boulevard Estrella 555', 'EnCamino', '2024-07-24');

INSERT INTO tb_detalle_pedidos (id_producto, cantidad_producto, precio_producto, calificacion_producto, comentario_producto, fecha_valoracion, estado_comentario, id_pedido) VALUES
(1, 2, 29.99, '5', 'Excelente calidad', '2024-07-01', 1, 1),
(2, 1, 29.99, '4', 'Buen producto', '2024-07-02', 1, 2),
(3, 1, 29.99, '3', 'Regular', '2024-07-03', 1, 3),
(4, 1, 29.99, '2', 'No me gustó', '2024-07-04', 1, 4),
(5, 1, 34.99, '5', 'Perfecto', '2024-07-05', 1, 5),
(6, 1, 34.99, '4', 'Muy bueno', '2024-07-06', 1, 6),
(7, 1, 34.99, '3', 'Aceptable', '2024-07-07', 1, 7),
(8, 1, 34.99, '2', 'No está mal', '2024-07-08', 1, 8),
(9, 1, 24.99, '1', 'No lo recomiendo', '2024-07-09', 1, 9),
(10, 1, 24.99, '5', 'Increíble', '2024-07-10', 1, 10),
(11, 1, 24.99, '4', 'Muy satisfecho', '2024-07-11', 1, 11),
(12, 1, 24.99, '3', 'Bien', '2024-07-12', 1, 12),
(13, 1, 89.99, '2', 'Malo', '2024-07-15', 1, 13),
(14, 1, 89.99, '1', 'Terrible', '2024-07-15', 1, 14),
(15, 1, 89.99, '5', 'Magnífico', '2024-07-15', 1, 15),
(16, 1, 89.99, '4', 'Genial', '2024-07-16', 1, 16);


INSERT INTO tb_categorias (id_categoria, nombre, imagen, descripcion) VALUES 
(1, 'Futbol', 'CategoriaFutbol.png', 'Todos los productos relacionados con el fútbol'),
(2, 'Baloncesto', 'CategoriaBaloncesto.png', 'Todos los productos relacionados con el baloncesto'),
(3, 'Voleibol', 'CategoriaVoleibol.png', 'Todos los productos relacionados con el voleibol'),
(4, 'Sneackers', 'CategoriaZapatos.png', 'Todos los sneackers');

INSERT INTO tb_productos (id_producto, nombre_producto, descripcion_producto, precio_producto, existencias_producto, imagen_producto, id_categoria, estado_producto, id_administrador, fecha_registro) 
VALUES 
(1, 'Balon de Futbol', 'Balon oficial para partidos de futbol.', 29.99, 150, 'img5.png', 1, 1, 1, '2024-05-30'),
(2, 'Balon de Futbol', 'Balon oficial para partidos de futbol.', 29.99, 150, 'img5.png', 1, 1, 1, '2024-05-30'),
(3, 'Balon de Futbol', 'Balon oficial para partidos de futbol.', 29.99, 150, 'img5.png', 1, 1, 1, '2024-05-30'),
(4, 'Balon de Futbol', 'Balon oficial para partidos de futbol.', 29.99, 150, 'img5.png', 1, 1, 1, '2024-05-30'),
(5, 'Balon de Basquetball', 'Balon oficial para partidos de basquetball.', 34.99, 100, 'img6.png', 2, 1, 1, '2024-05-30'),
(6, 'Balon de Basquetball', 'Balon oficial para partidos de basquetball.', 34.99, 100, 'img6.png', 2, 1, 1, '2024-05-30'),
(7, 'Balon de Basquetball', 'Balon oficial para partidos de basquetball.', 34.99, 100, 'img6.png', 2, 1, 1, '2024-05-30'),
(8, 'Balon de Basquetball', 'Balon oficial para partidos de basquetball.', 34.99, 100, 'img6.png', 2, 1, 1, '2024-05-30'),
(9, 'Balon de Voleyball', 'Balon oficial para partidos de voleyball.', 24.99, 200, 'img7.png', 3, 1, 1, '2024-05-30'),
(10, 'Balon de Voleyball', 'Balon oficial para partidos de voleyball.', 24.99, 200, 'img7.png', 3, 1, 1, '2024-05-30'),
(11, 'Balon de Voleyball', 'Balon oficial para partidos de voleyball.', 24.99, 200, 'img7.png', 3, 1, 1, '2024-05-30'),
(12, 'Balon de Voleyball', 'Balon oficial para partidos de voleyball.', 24.99, 200, 'img7.png', 3, 1, 1, '2024-05-30'),
(13, 'Sneackers Deportivos', 'Zapatos deportivos de alta calidad.', 89.99, 50, 'img1.png', 4, 1, 1, '2024-05-30'),
(14, 'Sneackers Deportivos', 'Zapatos deportivos de alta calidad.', 89.99, 50, 'img2.png', 4, 1, 1, '2024-05-30'),
(15, 'Sneackers Deportivos', 'Zapatos deportivos de alta calidad.', 89.99, 50, 'img3.png', 4, 1, 1, '2024-05-30'),
(16, 'Sneackers Deportivos', 'Zapatos deportivos de alta calidad.', 89.99, 50, 'img4.png', 4, 1, 1, '2024-05-30');

INSERT INTO tb_tallas (nombre) VALUES
('XS'),
('S'),
('M'),
('L'),
('XL');

INSERT INTO tb_colores (nombre) VALUES
('Rojo'),
('Azul'),
('Verde'),
('Negro'),
('Blanco');

INSERT INTO tb_marcas (nombre) VALUES
('Nike'),
('Adidas'),
('Puma'),
('Reebok'),
('Under Armour');

INSERT INTO tb_deportes (nombre) VALUES
('Fútbol'),
('Baloncesto'),
('Voleibol'),
('Tenis'),
('Natación');

INSERT INTO tb_generos (nombre) VALUES
('Masculino'),
('Femenino'),
('Unisex'),
('Niños'),
('Niñas');

SELECT * FROM tb_administradores;

SELECT * FROM tb_clientes;

SELECT * FROM tb_tallas;

SELECT * FROM tb_categorias;

SELECT * FROM tb_productos;

SELECT * FROM tb_detalle_pedidos;

SELECT * FROM tb_pedidos;

SELECT * FROM tb_colores;

SELECT * FROM tb_marcas;

SELECT * FROM tb_deportes;

SELECT * FROM tb_generos;

SELECT * FROM tb_imagenes;


