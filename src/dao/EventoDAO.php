<?php

require_once __DIR__ . '/../../db/Database.php';

class EventoDAO {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function inserir($request) {
        $query = "INSERT INTO evento (titulo, descricao, data_inicio, data_fim, local, tipo_tecnologia_id, imagem_url) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $titulo = $request['titulo'];
        $descricao = $request['descricao'];
        $dataInicio = $request['data_inicio'];
        $dataFim = $request['data_fim'];
        $local = $request['local'];
        $tipoTecnologiaId = $request['tipo_tecnologia_id'];
        $imagemUrl = $request['imagem_url'];
        
        $stmt->bindParam(1, $titulo);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $dataInicio);
        $stmt->bindParam(4, $dataFim);
        $stmt->bindParam(5, $local);
        $stmt->bindParam(6, $tipoTecnologiaId);
        $stmt->bindParam(7, $imagemUrl);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function buscarTodos() {
        $query = "SELECT evento.*, tipos_tecnologia.nome AS categoria_nome 
              FROM evento 
              INNER JOIN tipos_tecnologia ON evento.tipo_tecnologia_id = tipos_tecnologia.id 
              ORDER BY evento.data_inicio DESC";
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

    public function buscarTodasCategorias() {
        $query = "SELECT * FROM tipos_tecnologia ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;  
        } catch (PDOException $e) {
            error_log("Erro ao buscar categorias: " . $e->getMessage());
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
    
    public function buscarUrlImagemPorId($eventoId) {
        $query = "SELECT url_imagem FROM evento WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $eventoId);
        
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result['url_imagem'];  
            } else {
                return null;  
            }
        } catch (PDOException $e) {
            error_log("Erro ao buscar url da imagem: " . $e->getMessage());
            return null;
        }
    }

}