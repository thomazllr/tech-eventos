<?php

require_once __DIR__ . '/../../db/Database.php';

class UsuarioDAO {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function inserir($request) {
        $query = "INSERT INTO usuario (nome, email, senha, cargo_id) 
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $nome = $request['nome'];
        $email = $request['email'];
        $senha = password_hash($request['senha'], PASSWORD_BCRYPT);
        $cargo_id = $request['cargo_id'] ?? 1; // 1 = USUARIO por padrão

        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senha);
        $stmt->bindParam(4, $cargo_id);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    public function buscarTodos() {
        $query = "SELECT u.*, c.nome as cargo_nome 
                  FROM usuario u 
                  JOIN cargo c ON u.cargo_id = c.id";
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
        $query = "SELECT u.*, c.nome as cargo_nome 
                  FROM usuario u 
                  JOIN cargo c ON u.cargo_id = c.id 
                  WHERE u.email = ?";
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
        $query = "SELECT u.*, c.nome as cargo_nome 
                  FROM usuario u 
                  JOIN cargo c ON u.cargo_id = c.id 
                  WHERE u.id = ?";
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
    
    public function atualizarCargo($id, $cargo_id) {
        $query = "UPDATE usuario SET cargo_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $cargo_id);
        $stmt->bindParam(2, $id);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar cargo do usuário: " . $e->getMessage());
            return false;
        }
    }
    
    public function buscarCargos() {
        $query = "SELECT * FROM cargo";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar cargos: " . $e->getMessage());
            return false;
        }
    }
}