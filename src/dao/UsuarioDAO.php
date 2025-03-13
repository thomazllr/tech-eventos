<?php

require_once __DIR__ . '/../../db/Database.php';

class UsuarioDAO {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function inserir($request) {
        $query = "INSERT INTO usuario (nome, email, senha) 
                  VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $nome = $request['nome'];
        $email = $request['email'];
        $senha = password_hash($request['senha'], PASSWORD_BCRYPT);

        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senha);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    public function buscarTodos() {
        $query = "SELECT * FROM usuario";
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;  
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuários: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPorEmail($email) {
        $query = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        
        try {
            $stmt->execute();
            return $stmt->fetch(mode: PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por email: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        
        try {
            $stmt->execute();
            return $stmt->fetch(mode: PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por id: " . $e->getMessage());
            return false;
        }
    }

    public function autenticar($email, $senha) {
        $usuario = $this->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        return false;
    }
}