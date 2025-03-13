<?php

require_once __DIR__ . '/../dao/EventoDAO.php';

class EventoController {

    private $eventoDAO;
    
    public function __construct() {
        $this->eventoDAO = new EventoDAO();
    }

    public function criarEvento($dados) {
        if (empty($dados['titulo']) || 
            empty($dados['data_inicio']) || 
            empty($dados['data_fim']) || 
            empty($dados['tipo_tecnologia_id'])) {
            return false; 
        }
        
        return $this->eventoDAO->inserir($dados);
    }

    public function listarEventos() {
        return $this->eventoDAO->buscarTodos();
    }
}