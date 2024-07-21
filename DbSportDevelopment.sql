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
  fecha_valoracion DATE NOT NULL DEFAULT (CURRENT_TIME()),
  estado_comentario BOOLEAN NOT NULL,
  id_pedido INT(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tb_pedidos (
  id_pedido INT(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  id_cliente INT(10) UNSIGNED NOT NULL,
  direccion_pedido VARCHAR(250) NOT NULL,
  estado_pedido ENUM('Pendiente','Finalizado','Entregado','Anulado') NOT NULL,
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


INSERT INTO tb_pedidos (id_cliente, direccion_pedido, estado_pedido, fecha_registro) VALUES
(1, 'Av. Siempre Viva 742', 'Finalizado', '2024-07-06'),
(2, 'Calle Falsa 123', 'Finalizado', '2024-07-07'),
(3, 'Boulevard de los Sueños 456', 'Finalizado', '2024-07-08'),
(4, 'Avenida de la Libertad 789', 'Finalizado', '2024-07-09'),
(5, 'Plaza Central 101', 'Finalizado', '2024-07-10');

INSERT INTO tb_detalle_pedidos (id_producto, cantidad_producto, precio_producto, calificacion_producto, comentario_producto, fecha_valoracion, estado_comentario, id_pedido) VALUES
(1, 2, 29.99, '5', 'Buen producto', '2024-07-06', 1, 6),
(2, 1, 34.99, '4', 'Muy útil', '2024-07-07', 1, 7),
(3, 3, 24.99, '5', 'Excelente', '2024-07-08', 1, 8),
(4, 2, 89.99, '3', 'Satisfactorio', '2024-07-09', 1, 9),
(5, 1, 89.99, '5', 'Recomendado', '2024-07-10', 1, 10);


INSERT INTO tb_categorias (id_categoria, nombre, imagen, descripcion) 
VALUES 
(1, 'Futbol', 'CategoriaFutbol.png', 'Articulos deportivos para futbol'),
(2, 'Basquetball', 'CategoriaBaloncesto.png', 'Articulos deportivos para Basquetball'),
(3, 'Voleyball', 'CategoriaVoleyball.png', 'Articulos deportivos para Voleyball'),
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


INSERT INTO tb_administradores (nombre, apellido, correo_administrador, alias_administrador, clave_administrador) VALUES
('Admin1', 'Uno', 'admin1@example.com', 'admin1', 'password1'),
('Admin2', 'Dos', 'admin2@example.com', 'admin2', 'password2'),
('Admin3', 'Tres', 'admin3@example.com', 'admin3', 'password3'),
('Admin4', 'Cuatro', 'admin4@example.com', 'admin4', 'password4'),
('Admin5', 'Cinco', 'cinco@example.com', 'admin5', 'password5');


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


INSERT INTO tb_imagenes (nombre_imagen, id_producto) VALUES
('producto1.png', 1),
('producto2.png', 2),
('producto3.png', 3),
('producto4.png', 4),
('producto5.png', 5);


SELECT * FROM tb_administradores;

SELECT * FROM tb_clientes;

SELECT * FROM tb_tallas;

SELECT * FROM tb_categorias;

SELECT * FROM tb_productos;

SELECT * FROM tb_detalle_pedidos;

SELECT * FROM tb_pedidos;

SELECT * FROM tb_departamentos;

SELECT * FROM tb_colores;

SELECT * FROM tb_marcas;

SELECT * FROM tb_deportes;

SELECT * FROM tb_generos;

SELECT * FROM tb_imagenes;





