<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../public/css/form-usuario.css">
</head>
<body>
    <header class="header">
        <h1>
            <p>TechEventos</p>
        </h1>
    </header>
    <main class="container">
        <div class="form-wrapper">
            <form class="form" method="post" action="../src/controller/UsuarioController.php">
                <input type="hidden" name="acao" value="login">
                <h1 class="form-title">Login</h1>
                
                <div class="form-group">
                    <label for="usuario-email">Email</label>
                    <input type="email" id="usuario-email" name="email" class="form-input" required placeholder="seuemail@gmail.com">
                </div>
                
                <div class="form-group">
                    <label for="usuario-senha">Senha</label>
                    <input type="password" id="usuario-senha" name="senha" class="form-input" required placeholder="Digite sua senha" minlength="4" maxlength="20">
                </div>
                
                <div class="form-group form-actions">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>

                <div class="form-link">
                    <p>Não tem uma conta? <a href="cadastro-usuario.php" class="link">Cadastre-se</a></p>
                </div>
            </form>
        </div>

        <?php
            /* OBS: a mensagem de sucesso é só para testes(vai ter só a de erro). a ideia é se der certo o usuario será mandado para a tela de login. */
            session_start();
            if (isset($_SESSION['mensagem'])) {
                echo '<div class="alert ' . ($_SESSION['status'] === 'sucesso' ? 'alert-success' : 'alert-danger') . '">';
                echo $_SESSION['mensagem'];
                echo '</div>';

                /*limpar a mensagem após exibir*/
                unset($_SESSION['mensagem']);
                unset($_SESSION['status']);
            }
        ?>
    </main>
</body>
</html>