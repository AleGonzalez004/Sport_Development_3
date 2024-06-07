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

CREATE TABLE tb_departamentos (
 id_departamento INT UNSIGNED AUTO_INCREMENT NOT NULL,
 departamento VARCHAR(1000) NOT NULL,
 PRIMARY KEY (id_departamento)
);

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





