CREATE DATABASE IF NOT EXISTS meusistema;
USE meusistema;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(100) UNIQUE NOT NULL,
  senha VARCHAR(255) NOT NULL
);

CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(20),
  nome VARCHAR(100),
  tempo_garantia INT,
  status BOOLEAN
);

CREATE TABLE ordens_servico (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero_ordem VARCHAR(20),
  data_abertura DATE,
  nome_consumidor VARCHAR(100),
  cpf_consumidor VARCHAR(14),
  defeito_reclamado TEXT,
  solucao_tecnico TEXT,
  produto_id INT,
  user_id INT,
  FOREIGN KEY (produto_id) REFERENCES produtos(id),
  FOREIGN KEY (user_id) REFERENCES usuarios(id)
);
