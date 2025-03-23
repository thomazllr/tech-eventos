CREATE TABLE tipos_tecnologia (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    descricao VARCHAR(255)
);

INSERT INTO tipos_tecnologia (nome, descricao) VALUES
('IA', 'Eventos relacionados à Inteligência Artificial e Machine Learning'),
('DEVOPS', 'Eventos relacionados às práticas de DevOps e CI/CD'),
('FRONTEND', 'Eventos relacionados ao desenvolvimento frontend e UX/UI'),
('BACKEND', 'Eventos relacionados ao desenvolvimento backend'),
('MOBILE', 'Eventos relacionados ao desenvolvimento de aplicativos móveis'),
('CIBERSEGURANCA', 'Eventos relacionados à segurança da informação e cibersegurança');

CREATE TABLE evento (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    imagem_url TEXT,
    data_inicio TIMESTAMP NOT NULL,
    data_fim TIMESTAMP NOT NULL,
    local VARCHAR(100),
    tipo_tecnologia_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_tecnologia_id) REFERENCES tipos_tecnologia(id)
);

INSERT INTO evento (titulo, descricao, imagem_url, data_inicio, data_fim, local, tipo_tecnologia_id, created_at, updated_at) VALUES
('Summit IA 2025: Inovação e Inteligência Artificial no Futuro Digital', 
 'O Summit IA 2025 é o evento definitivo para profissionais, pesquisadores e entusiastas da Inteligência Artificial. Reunindo especialistas de renome, painéis interativos e demonstrações inovadoras, exploraremos como a IA está transformando negócios, ciência e sociedade.',
 'https://images.unsplash.com/photo-1535378917042-10a22c95931a?q=80&w=2048&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
 '2025-03-25 14:00:00',
 '2025-03-27 18:00:00',
 'UFT - Bloco III',
 1, 
 CURRENT_TIMESTAMP, 
 CURRENT_TIMESTAMP
),
('CyberSec 2025: Protegendo o Futuro Digital', 
 'O CyberSec 2025 é o principal evento para profissionais de cibersegurança, reunindo especialistas, empresas e entusiastas para discutir as ameaças digitais mais avançadas e as melhores estratégias de defesa.',
 'https://plus.unsplash.com/premium_photo-1663091633166-20ef12aa7b4e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
 '2025-04-27 15:00:00',
 '2025-04-30 19:00:00',
 'UFT - Bloco III',
 6,
 CURRENT_TIMESTAMP,
 CURRENT_TIMESTAMP
);

CREATE TABLE cargo (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

INSERT INTO cargo (nome) VALUES
('USUARIO'),
('ADMIN');

CREATE TABLE usuario (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cargo_id INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cargo_id) REFERENCES cargo(id)
);

CREATE EXTENSION IF NOT EXISTS pgcrypto;

INSERT INTO usuario (nome, email, senha, cargo_id)  
VALUES ('User', 'user@email.com', crypt('1234', gen_salt('bf')), 1);

-- Inserir usuário admin com senha hash
INSERT INTO usuario (nome, email, senha, cargo_id)  
VALUES ('Admin', 'admin@email.com', crypt('1234', gen_salt('bf')), 2);
