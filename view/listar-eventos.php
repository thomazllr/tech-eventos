<?php
require_once '../src/controller/EventoController.php';
require_once '../src/controller/UsuarioController.php';

$eventoController = new EventoController();
$usuarioController = new UsuarioController();
$categorias = $eventoController->listarCategorias();
$usuarioCargo = $usuarioController->getUsuarioCargo();
$usuarioLogado = $usuarioController->isUsuarioLogado();


$filtro = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['categoria_nome'])) {
        $filtro['categoria_nome'] = $_GET['categoria_nome'];
    }
    if (!empty($_GET['titulo'])) {
        $filtro['titulo'] = $_GET['titulo'];
    }
}

$eventos = $eventoController->listarEventosFiltrados($filtro);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Tech</title>
    <link rel="stylesheet" href="../public/css/global.css">
    <link rel="stylesheet" href="../public/css/estilos-inicial.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">Tech</div>
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
                        <li><a href="/tech-eventos/view/criar-evento.php" class="btn-register-event">Cadastrar Eventos</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Barra de Pesquisa -->
    <section class="search-bar">
        <form method="get">
            <input type="text" name="titulo" placeholder="Procurar por eventos">
            <select name="categoria_nome">
                <option value="">Selecione a categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['nome']; ?>">
                        <?= $categoria['nome']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-search">Buscar</button>
        </form>
    </section>

    <main>
        <h2 class="title">EVENTOS DA PLATAFORMA</h2>
        <div class="event-list">
            <?php if ($eventos != null && count($eventos) > 0) {
                foreach ($eventos as $evento): ?>
                    <div class="event">
                        <img src="<?= $evento['imagem_url']; ?>" alt="Imagem do evento">
                        <div class="event-info">
                            <h3><?= $evento['titulo']; ?></h3>
                            <p><strong>Local:</strong>
                                <?= htmlspecialchars($evento['local']); ?> - <?= date('d/m/Y', strtotime($evento['data_inicio'])); ?> - <?= date('d/m/Y', strtotime($evento['data_fim'])); ?></p>
                            <p><strong>Categoria:</strong> <span class="bold"><?= $evento['categoria_nome']; ?></span></p>
                            <button class="btn-subscribe" onclick="openModal('modal-<?= $evento['id']; ?>')">Saiba mais</button>
                        </div>
                    </div>

                    <!-- Modal para este evento -->
                    <div id="modal-<?= $evento['id']; ?>" class="modal">
                        <div class="modal-content">
                            <span class="close-modal" onclick="closeModal('modal-<?= $evento['id']; ?>')">&times;</span>
                            <div class="modal-header">
                                <h2><?= $evento['titulo']; ?></h2>
                            </div>
                            <div class="modal-body">
                                <img src="<?= $evento['imagem_url']; ?>" alt="Imagem do evento">
                                <div class="modal-info">
                                    <p><strong>Local:</strong> <?= htmlspecialchars($evento['local']); ?></p>
                                    <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($evento['data_inicio'])); ?> até <?= date('d/m/Y', strtotime($evento['data_fim'])); ?></p>
                                    <p><strong>Categoria:</strong> <?= $evento['categoria_nome']; ?></p>
                                    <p><strong>Descrição:</strong> <?= htmlspecialchars($evento['descricao']); ?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn-subscribe">Inscrever-se</button>
                            </div>
                        </div>
                    </div>

            <?php endforeach;
            } ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-right">
                <ul>
                    <li>Email: uft@email</li>
                    <li>Telefone: (62) 3150-0852</li>
                    <li>Endereço: UFT - Palmas, Bloco 3</li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="../public/js/modal.js"></script>
</body>

</html>