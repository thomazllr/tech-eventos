<?php

require_once __DIR__ . '/../../db/Database.php';

class EventoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function inserir($request) {
        $query = "INSERT INTO evento (titulo, descricao, data_inicio, data_fim, local, tipo_tecnologia_id) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $titulo = $request['titulo'];
        $descricao = $request['descricao'];
        $dataInicio = $request['data_inicio'];
        $dataFim = $request['data_fim'];
        $local = $request['local'];
        $tipoTecnologiaId = $request['tipo_tecnologia_id'];
        
        $stmt->bindParam(1, $titulo);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $dataInicio);
        $stmt->bindParam(4, $dataFim);
        $stmt->bindParam(5, $local);
        $stmt->bindParam(6, $tipoTecnologiaId);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function buscarTodos() {
        $query = "SELECT * FROM evento ORDER BY data_inicio DESC";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;  
        } catch (PDOException $e) {
            error_log("Erro ao buscar eventos: " . $e->getMessage());
            return false;
        }
    }

    public function buscarDescricaoTecnologiaPorId($tipoTecnologiaId) {
        $query = "SELECT descricao FROM tipos_tecnologia WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $tipoTecnologiaId);
        
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['descricao'];  
            } else {
                return null;  
            }
        } catch (PDOException $e) {
            error_log("Erro ao buscar nome da tecnologia: " . $e->getMessage());
            return null;
        }
    }

    public function buscarNomeTecnologiaPorId($tipoTecnologiaId) {
        $query = "SELECT nome FROM tipos_tecnologia WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $tipoTecnologiaId);
        
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['nome'];  
            } else {
                return null;  
            }
        } catch (PDOException $e) {
            error_log("Erro ao buscar nome da tecnologia: " . $e->getMessage());
            return null;
        }
    }
    
    

}