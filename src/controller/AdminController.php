<?php

require_once __DIR__ . '/UsuarioController.php';

class AdminController {
    private $usuarioController;
    
    public function __construct() {
        $this->usuarioController = new UsuarioController();
    }
    
    public function verificarPermissao() {
        if (!$this->usuarioController->verificarPermissaoAdmin()) {
            $_SESSION['mensagem'] = 'Acesso negado. Você não tem permissão para acessar esta área.';
            $_SESSION['status'] = 'erro';
            header("Location: /tech-eventos/view/login-usuario.php");
            exit();
        }
    }
    
    public function listarUsuarios() {
        if (!$this->usuarioController->isAdmin()) {
            return ['status' => 'erro', 'mensagem' => 'Você não tem permissão para realizar esta ação.'];
        }
        
        $usuarioDAO = new UsuarioDAO();
        $usuarios = $usuarioDAO->buscarTodos();
        return $usuarios;
    }
}