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