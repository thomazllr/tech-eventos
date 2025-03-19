# Projeto: Plataforma de Eventos

## Universidade Federal do Tocantins (UFT)
**Curso:** Ciência da Computação  
**Disciplina:** Engenharia de Software  
**Semestre:** 1º Semestre de 2025  
**Professor:** Edeilson Milhomem 

## 👥 Integrantes do Time
- Guilherme Thomaz Brito
- Ítalo Henrik Batista Reis
- Jhennifer da Silva Azevedo
- Luiz Felipe da Paz Leal
- Marcos Freire de Melo

## 📌 Descrição Geral do Projeto
Este projeto consiste em uma plataforma web para exibição e gerenciamento de eventos, com foco em eventos acadêmicos e tecnológicos. O site permite que usuários naveguem por eventos categorizados, façam login e que um administrador cadastre novos eventos.

## 🎯 Objetivo
Facilitar a divulgação de eventos, proporcionando uma experiência intuitiva para os usuários que buscam informações sobre conferências, palestras e outros encontros acadêmicos e tecnológicos.

## ✅ Requisitos Implementados
- Exibição de eventos organizados por categoria
- Barra de pesquisa para encontrar eventos específicos
- Sistema de login e cadastro de usuários
- Painel administrativo para criação de eventos

## 🛠️ Configuração e Execução

### 🔹 Pré-requisitos
Certifique-se de ter instalado:
- **XAMPP**
- **Docker Desktop**
- **DBeaver**
- **PostgreSQL rodando via Docker**

### 🔹 Clonando o repositório
```sh
 git clone https://github.com/thomazllr/tech-eventos.git
 cd tech-eventos
```

### 🔹 Configuração do Apache para PostgreSQL no XAMPP
1. Abra o arquivo `php.ini`, localizado em `C:\xampp\php\php.ini`.
2. Encontre e descomente (remova o `;` do início) as seguintes linhas:
   ```
   extension=pgsql
   extension=pdo_pgsql
   ```  
3. Reinicie o Apache pelo painel de controle do XAMPP para aplicar as mudanças.

### 🔹 Configuração do Banco de Dados no Docker
1. Certifique-se de que o **Docker Desktop** está instalado e em execução.
2. No terminal ou prompt de comando, execute o seguinte comando para rodar um container PostgreSQL:
   ```sh
   docker run --name postgres-container -e POSTGRES_USER=postgres -e POSTGRES_PASSWORD=postgres -e POSTGRES_DB=postgres -p 5432:5432 -d postgres
   ```
3. Isso criará um banco de dados chamado **postgres** e rodará na porta `5432`.

### 🔹 Configuração do Banco de Dados no DBeaver
1. Baixe e instale o **DBeaver**: [https://dbeaver.io/download/](https://dbeaver.io/download/)
2. Abra o DBeaver e crie uma nova conexão:
   - **Banco de dados:** PostgreSQL  
   - **Host:** `localhost`  
   - **Porta:** `5432`  
   - **Usuário:** `postgres`  
   - **Senha:** `postgres`  
   - **Database:** `postgres`  
3. Conecte-se e execute os scripts SQL necessários para criar as tabelas do projeto.

### 🔹 Executando o Projeto
1. Coloque o arquivo do projeto `tech-eventos` dentro do diretório `htdocs` do XAMPP, localizado em `C:\xampp\htdocs`.
2. Certifique-se de que o **Apache** está rodando no painel do XAMPP.
3. No navegador, acesse:
   ```
   http://localhost/tech-eventos/
   ```
4. Acesse view e depois `listar-eventos.php`

  Pronto!

