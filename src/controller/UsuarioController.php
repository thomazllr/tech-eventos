<?php

session_start();
require_once __DIR__ . '/../../dao/UsuarioDAO.php';
require_once __DIR__ . '/../../../dir-config.php';

class UsuarioController {
    private $usuarioDAO;
    
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }
    
    public function registrarUsuario($dados) {
        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['senha']) || empty($dados['confirmacao_senha'])) {
            return ['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.'];
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'erro', 'mensagem' => 'Email inválido.'];
        }
        
        if ($dados['senha'] !== $dados['confirmacao_senha']) {
            return ['status' => 'erro', 'mensagem' => 'As senhas não coincidem.'];
        }
        
        if ($this->usuarioDAO->buscarPorEmail($dados['email'])) {
            return ['status' => 'erro', 'mensagem' => 'Email já cadastrado.'];
        }
        
        $idUsuario = $this->usuarioDAO->inserir($dados);
        if ($idUsuario) {
            return ['status' => 'sucesso', 'mensagem' => 'Usuário cadastrado com sucesso.', 'id' => $idUsuario];
        }
        
        return ['status' => 'erro', 'mensagem' => 'Erro ao cadastrar usuário.'];
    }
    
    public function loginUsuario($dados) {
        if (empty($dados['email']) || empty($dados['senha'])) {
            return ['status' => 'erro', 'mensagem' => 'Email e senha são obrigatórios.'];
        }
        
        $usuario = $this->usuarioDAO->autenticar($dados['email'], $dados['senha']);
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            return ['status' => 'sucesso', 'mensagem' => 'Login realizado com sucesso.'];
        }
        
        return ['status' => 'erro', 'mensagem' => 'Credenciais inválidas.'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();
    
    if (isset($_POST['acao']) && $_POST['acao'] === 'registrar') {
        $dadosUsuario = [
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? '',
            'confirmacao_senha' => $_POST['confirmacao_senha'] ?? ''
        ];
        $resultado = $controller->registrarUsuario($dadosUsuario);
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'login') {
        $dadosLogin = [
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? ''
        ];
        $resultado = $controller->loginUsuario($dadosLogin);
    }
    
    $_SESSION[$resultado['status']] = $resultado['mensagem'];
    /* $redirectPage = $resultado['status'] === 'sucesso' ? 'home.php' : 'login.php'; */
    /* header("Location: " . BASE_URL . "view/" . $redirectPage); */
    exit();
}