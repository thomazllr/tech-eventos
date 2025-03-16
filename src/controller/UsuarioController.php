<?php

session_start();
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../../db/db-config.php';

class UsuarioController {
    private $usuarioDAO;
    
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }
    
    public function registrarUsuario($dados) {
        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['senha']) || empty($dados['confirmacao-senha'])) {
            return ['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.'];
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'erro', 'mensagem' => 'Email inválido.'];
        }
        
        if ($this->usuarioDAO->buscarPorEmail($dados['email'])) {
            return ['status' => 'erro', 'mensagem' => 'Email já cadastrado.'];
        }

        if ($dados['senha'] !== $dados['confirmacao-senha']) {
            return ['status' => 'erro', 'mensagem' => 'As senhas não coincidem.'];
        }
           
        if (!isset($dados['cargo_id']) || empty($dados['cargo_id'])) {
            $dados['cargo_id'] = 1;
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

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return ['status' => 'erro', 'mensagem' => 'Email inválido.'];
        }
        
        $usuario = $this->usuarioDAO->buscarPorEmail($dados['email']);
        if ($usuario && password_verify($dados['senha'], $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_cargo'] = $usuario['cargo_nome'];
            $_SESSION['usuario_cargo_id'] = $usuario['cargo_id'];
            $_SESSION['usuario_logado'] = true;
            $_SESSION['login_time'] = time();
            $_SESSION['ultimo_acesso'] = time();
            return ['status' => 'sucesso', 'mensagem' => 'Login realizado com sucesso.'];
        }
        return ['status' => 'erro', 'mensagem' => 'Credenciais inválidas.'];
    }

    public function isUsuarioLogado() {
        return isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
    }

    public function getUsuarioCargo() {
        if ($this->isUsuarioLogado()) {
            return $_SESSION['usuario_cargo'] ?? null;
        }
        return null;
    }
    
    public function isAdmin() {
        return $this->isUsuarioLogado() && $this->getUsuarioCargo() === 'ADMIN';
    }
    
    public function logout() {
        $_SESSION = array();
        session_destroy();
        return ['status' => 'sucesso', 'mensagem' => 'Logout realizado com sucesso.'];
    }
    
    public function verificarSessao() {
        if (!$this->isUsuarioLogado()) {
            return false;
        }
        
        $tempoInatividade = 30 * 60; // 30 minutos em segundos
        if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso'] > $tempoInatividade)) {
            $this->logout();
            return false;
        }
        
        $_SESSION['ultimo_acesso'] = time();
        return true;
    }
    
    public function verificarPermissaoAdmin() {
        if (!$this->verificarSessao()) {
            return false;
        }
        
        if (!$this->isAdmin()) {
            return false;
        }
        
        return true;
    }
    
    public function getCargos() {
        return $this->usuarioDAO->buscarCargos();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();
    
    if (isset($_POST['acao']) && $_POST['acao'] === 'registrar') {
        $dadosUsuario = [
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? '',
            'confirmacao-senha' => $_POST['confirmacao-senha'] ?? '',
            'cargo_id' => $_POST['cargo_id'] ?? 1 // 1 = USUARIO por padrão
        ];
        $resultado = $controller->registrarUsuario($dadosUsuario);
        $_SESSION['mensagem'] = $resultado['mensagem'];
        $_SESSION['status'] = $resultado['status'];
        if ($resultado['status'] === 'sucesso') {
            header("Location: ../../view/login-usuario.php");
        } else {
            header("Location: ../../view/cadastro-usuario.php");
        }
        exit();
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'login') {
        $dadosLogin = [
            'email' => $_POST['email'] ?? '',
            'senha' => $_POST['senha'] ?? ''
        ];
        $resultado = $controller->loginUsuario($dadosLogin);
        $_SESSION['mensagem'] = $resultado['mensagem'];
        $_SESSION['status'] = $resultado['status'];
        
        header("Location: ../../view/login-usuario.php");
        exit();
    }
}