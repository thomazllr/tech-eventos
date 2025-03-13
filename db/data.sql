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
('CIBERSEGURANCA', 'Eventos relacionados à segurança da informação e cibersegurança'),

CREATE TABLE eventos (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_inicio TIMESTAMP NOT NULL,
    data_fim TIMESTAMP NOT NULL,
    local VARCHAR(100),
    tipo_tecnologia_id INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_tecnologia_id) REFERENCES tipos_tecnologia(id)
);
