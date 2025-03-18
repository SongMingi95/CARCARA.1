CREATE DATABASE carcara;

USE carcara;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);
CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    data_inicio DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    data_termino DATE,
    hora_termino_inicio TIME,
    hora_termino_fim TIME,
    local VARCHAR(255) NOT NULL,
    responsavel VARCHAR(255) NOT NULL
);
ALTER TABLE usuarios ADD COLUMN tipo ENUM('admin', 'padrao') NOT NULL DEFAULT 'padrao';

INSERT INTO usuarios (nome, cpf, email, senha, tipo) 
VALUES ('Administrador', '000.000.000-00', 'admin@carcara.com', 
        '$2y$10$uICVChvewtXxX3tdxmJOSeKDjuoqVIOM9nbbafVx7pEPHveJfvk/G', 'admin');

ALTER TABLE usuarios ADD COLUMN foto_perfil VARCHAR(255) NULL;
