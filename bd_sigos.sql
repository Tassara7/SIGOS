CREATE DATABASE IF NOT EXISTS sigos;
USE sigos;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  tipo VARCHAR(20) DEFAULT 'usuario'
);

CREATE TABLE ordens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL,
  prioridade VARCHAR(20) NOT NULL,
  status VARCHAR(20) DEFAULT 'aberta',
  usuario_id INT NOT NULL,
  tecnico_id INT NULL,
  observacao_tecnico TEXT NULL,
  data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
  data_conclusao DATETIME NULL
);