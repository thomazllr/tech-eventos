<?php
require_once '../src/controller/EventoController.php';  
require_once '../src/controller/UsuarioController.php';  

$eventoController = new EventoController();
$usuarioController = new UsuarioController();
$eventos = $eventoController->listarEventos();
$categorias = $eventoController->listarCategorias();
$usuarioCargo = $usuarioController->getUsuarioCargo();
$usuarioLogado = $usuarioController->isUsuarioLogado();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos PQND</title>
    <link rel="stylesheet" href="../public/css/global.css">
    <link rel="stylesheet" href="../public/css/estilos-inicial.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">PQND</div>
            <nav>
                <ul>
                    <?php if ($usuarioLogado): ?>
                        <li><span class="user-name">Olá, <?php echo $_SESSION['usuario_nome']; ?></span></li>
                        <li><a href="/tech-eventos/logout.php" class="btn-logout">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/tech-eventos/view/cadastro-usuario.php" class="btn-register-user">Registrar</a></li>
                        <li><a href="/tech-eventos/view/login-usuario.php" class="btn-login">Login</a></li>
                    <?php endif; ?>

                    <?php if ($usuarioCargo === 'ADMIN'): ?>
                        <!-- <li><a href="/tech-eventos/view/admin/dash-board.php" class="btn-admin">Dashboard Admin</a></li> -->
                        <li><a href="/tech-eventos/view/criar-evento.php" class="btn-register-event">Cadastrar Eventos</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Barra de Pesquisa -->
    <section class="search-bar">
        <input type="text" placeholder="Procurar por eventos">
        <select>
            <option value="">Selecione a categoria</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value= <?= $categoria['nome']; ?> >
                    <?= $categoria['nome']; ?>        
            </option>
            <?php endforeach; ?>
        </select>
        <button class="btn-search">Buscar</button>
    </section>

    <main>
        <h2 class="title">EVENTOS DA PLATAFORMA</h2>
        <div class="event-list">
            <?php if($eventos != null && count($eventos) > 0) {
                foreach ($eventos as $evento): ?> 
                <div class="event">
                    <img src="<?= $evento['imagem_url']; ?>" alt="Imagem do evento">
                    <div class="event-info">
                        <h3><?= $evento['titulo']; ?></h3>
                        <p><strong>Local:</strong> 
                        <?= htmlspecialchars($evento['local']); ?> - <?= date('d/m/Y', strtotime($evento['data_inicio'])); ?> - <?= date('d/m/Y', strtotime($evento['data_fim']));?></p>
                        <p><strong>Categoria:</strong> <span class="bold"><?= $evento['categoria_nome']; ?></span></p>
                        <button class="btn-subscribe">Saiba mais</button>
                    </div>
                </div>
            <?php endforeach; } ?>
        </div>
        <button class="btn-load-more">Mostrar Mais</button>
    </main>

    <footer>
        <div class="container">
            <div class="footer-right">
                <h3>PQND</h3>
                <ul>
                    <li>Email: #############</li>
                    <li>Telefone: #############</li>
                    <li>Endereço: UFT - Palmas, Bloco 3</li>
                </ul>
            </div>
            <div class="footer-left">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Sobre Nós</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>