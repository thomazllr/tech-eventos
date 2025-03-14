<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../public/css/global.css">
    <link rel="stylesheet" href="../public/css/cadastro-usuario.css">
</head>
<body>
    <header class="header">
        <h1>
            <p>TechEventos</p>
        </h1>
    </header>
    <main class="container-cadastro">
        <div class="form-wrapper">
            <form class="form-cadastro" method="post" action="../src/controller/UsuarioController.php">
                <input type="hidden" name="acao" value="registrar">
                <h1 class="form-title">Cadastro</h1>
                
                <div class="form-group">
                    <label for="usuario-nome">Nome</label>
                    <input type="text" id="usuario-nome" name="nome" class="form-input" required placeholder="Digite seu nome">
                </div>
                
                <div class="form-group">
                    <label for="usuario-email">Email</label>
                    <input type="email" id="usuario-email" name="email" class="form-input" required placeholder="seuemail@gmail.com">
                </div>
                
                <div class="form-group">
                    <label for="usuario-senha">Senha</label>
                    <input type="password" id="usuario-senha" name="senha" class="form-input" required placeholder="Digite sua senha">
                </div>
                
                <div class="form-group">
                    <label for="usuario-senha-confirmacao">Confirme a senha</label>
                    <input type="password" id="usuario-senha-confirmacao" name="confirmacao-senha" class="form-input" required placeholder="Confirme sua senha">
                </div>
                
                <div class="form-group form-actions">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
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