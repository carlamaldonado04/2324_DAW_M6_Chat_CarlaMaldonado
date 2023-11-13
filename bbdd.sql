-- Base datos
CREATE DATABASE db_whatsapp;
USE db_whatsapp; 

-- Tabla de Usuarios
CREATE TABLE tbl_usuarios (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,
    nombre VARCHAR(255),
    correo VARCHAR(255),
    contrasena VARCHAR(255)
);

-- Tabla de Solicitudes de Amistad
CREATE TABLE tbl_solicitudesAmistad (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    id_emisor INT,
    id_receptor INT,
    estado VARCHAR(20),
    FOREIGN KEY (id_emisor) REFERENCES tbl_usuarios(id_user),
    FOREIGN KEY (id_receptor) REFERENCES tbl_usuarios(id_user)
);

-- Tabla de Amigos
-- CREATE TABLE tbl_amigos (
--     AmistadID INT AUTO_INCREMENT PRIMARY KEY,
--     id_user1 INT,
--     id_user2 INT,
--     FOREIGN KEY (id_user1) REFERENCES tbl_usuarios(id_user),
--     FOREIGN KEY (id_user2) REFERENCES tbl_usuarios(id_user)
-- );

-- Tabla de Mensajes
CREATE TABLE tbl_mensajes (
    id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
    id_emisor INT,
    id_receptor INT,
    Mensaje VARCHAR(250),
    FechaEnvio DATE,
    FOREIGN KEY (id_emisor) REFERENCES tbl_usuarios(id_user),
    FOREIGN KEY (id_receptor) REFERENCES tbl_usuarios(id_user)
);
