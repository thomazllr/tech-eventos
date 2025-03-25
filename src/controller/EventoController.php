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
            empty($dados['tipo_tecnologia_id']) ||
            empty($dados['imagem_url'])) {
            return false;
        }
        
        return $this->eventoDAO->inserir($dados);
    }
    
    public function listarCategorias() {
        return $this->eventoDAO->buscarTodasCategorias();
    }

    public function listarEventos() {
        return $this->eventoDAO->buscarTodos();
    }

    //função para listar eventos filtrados por nome e categoria
    public function listarEventosFiltrados($filtro = []) {
        $eventos = $this->listarEventos();
        if (!empty($filtro)) {
            $eventos = array_filter($eventos, function($evento) use ($filtro) {
                foreach ($filtro as $key => $value) {
                    if (stripos($evento[$key], $value) === false) {
                        return false;
                    }
                }
                return true;
            });
        }
        return $eventos;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EventoController();
    
    $dadosEvento = [
        'titulo' => $_POST['titulo'] ?? '',
        'descricao' => $_POST['descricao'] ?? '',
        'data_inicio' => $_POST['data_inicio'] ?? '',
        'data_fim' => $_POST['data_fim'] ?? '',
        'local' => $_POST['local'] ?? '',
        'tipo_tecnologia_id' => $_POST['tipo_tecnologia_id'] ?? '',
        'imagem_url' => $_POST['imagem_url'] ?? 0
    ];
    
    $resultado = $controller->criarEvento($dadosEvento);
    
    if ($resultado) {
        $mensagem = "<div style='color: green;'>Evento criado com sucesso! ID: " . $resultado . "</div>";
    } else {
        $mensagem = "<div style='color: red;'>Erro ao criar evento. Verifique os dados informados.</div>";
    }
}