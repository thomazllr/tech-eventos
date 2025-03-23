<?php
require_once __DIR__ . '/../src/controller/EventoController.php';

$controller = new EventoController();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Evento</title>
    <link rel="stylesheet" href="../public/css/form-eventos.css">
</head>

<body>
    <h1>Criar Novo Evento</h1>

    <form method="post">
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao"></textarea>
        </div>

        <div class="form-group">
            <label for="data_inicio">Data Início:</label>
            <input type="datetime-local" name="data_inicio" id="data_inicio" required>
        </div>

        <div class="form-group">
            <label for="data_fim">Data Fim:</label>
            <input type="datetime-local" name="data_fim" id="data_fim" required>
        </div>

        <div class="form-group">
            <label for="local">Local:</label>
            <input type="text" name="local" id="local">
        </div>

        <div class="form-group">
            <label for="tipo_tecnologia_id">Tipo de Tecnologia:</label>
            <select name="tipo_tecnologia_id" id="tipo_tecnologia_id" required>
                <option value="">Selecione o tipo</option>
                <?php
                $categorias = $controller->listarCategorias();
                foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id']; ?>">
                        <?= htmlspecialchars($categoria['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="imagem_url">Url da Imagem:</label>
            <input type="text" name="imagem_url" id="imagem_url" required placeholder="Insira a imagem do evento">
        </div>

        <div class="form-group">
            <button type="submit">Criar Evento</button>
        </div>
    </form>

    <div class="links">
        <a href="listar-eventos.php">Voltar para Lista de Eventos</a>
    </div>
</body>

</html>