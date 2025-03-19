<?php
session_start();
require_once __DIR__ . '/src/controller/UsuarioController.php';

$usuarioController = new UsuarioController();
$resultado = $usuarioController->logout();

$_SESSION['mensagem'] = $resultado['mensagem'];
$_SESSION['status'] = $resultado['status'];

header('Location: /tech-eventos/view/login-usuario.php');
exit();