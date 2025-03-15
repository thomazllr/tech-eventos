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
            'confirmacao-senha' => $_POST['confirmacao-senha'] ?? ''
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