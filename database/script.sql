-- Criação do banco de dados (caso não exista)
CREATE DATABASE IF NOT EXISTS assim_saude CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE assim_saude;

-- Tabela: cargo
CREATE TABLE cargo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    salario DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: funcionario
CREATE TABLE funcionario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    dataNascimento DATE NOT NULL,
    cep VARCHAR(9) NOT NULL,
    logradouro VARCHAR(150) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    complemento VARCHAR(100) DEFAULT NULL,
    bairro VARCHAR(100) NOT NULL,
    municipio VARCHAR(100) NOT NULL,
    uf CHAR(2) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    cargoId INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_funcionario_cargo FOREIGN KEY (cargoId) REFERENCES cargo(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices adicionais para otimização de consultas
CREATE INDEX idx_funcionario_cargoId ON funcionario(cargoId);
CREATE INDEX idx_funcionario_nome ON funcionario(nome);
