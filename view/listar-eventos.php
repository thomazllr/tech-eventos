<?php
 require_once '../src/controller/EventoController.php';  
 require_once '../src/dao/EventoDAO.php';  
 
 
 $controller = new EventoController();
 $eventos = $controller->listarEventos();
 $categorias = $controller->listarCategorias();
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

    <!-- Header -->
    <header>
        <div class="container">
            <div class="logo">PQND</div>
            <nav>
                <ul>
                    <li><a href="#">Eventos</a></li>
                    <li><a href="#" class="btn-register">Registrar</a></li>
                    <li><a href="#" class="btn-login">Login</a></li>
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

    <!-- Lista de Eventos -->
    <main>
        <h2 class="title">EVENTOS DA PLATAFORMA</h2>
        <div class="event-list">
            <?php if($eventos != null && count($eventos) > 0) {
                foreach ($eventos as $evento): ?> 
                <div class="event">
                    <img src="https://unsplash.com/pt-br/fotografias/asimo-robot-doing-handsign-g29arbbvPjo" alt="Imagem do evento">
                    <div class="event-info">
                        <h3><?= $evento['titulo']; ?></h3>
                        <p><strong>Local:</strong> <?= $evento['local']; ?> - <?= $evento['data_inicio']; ?> - <?= $evento['data_fim']; ?></p>
                        <p><strong>Descrição:</strong> <?= $evento['descricao']; ?></p>
                        <p><strong>Categoria:</strong> <span class="bold"><?= $evento['categoria_nome']; ?></span></p>
                        <button class="btn-subscribe">Se Inscrever</button>
                    </div>
                </div>
            <?php endforeach; } ?>
        </div>
        <button class="btn-load-more">Mostrar Mais</button>
    </main>

    <!-- Footer -->
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