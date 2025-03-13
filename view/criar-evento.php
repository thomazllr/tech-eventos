<?php
require_once __DIR__ . '/../src/controller/EventoController.php';

$controller = new EventoController();
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dadosEvento = [
        'titulo' => $_POST['titulo'] ?? '',
        'descricao' => $_POST['descricao'] ?? '',
        'data_inicio' => $_POST['data_inicio'] ?? '',
        'data_fim' => $_POST['data_fim'] ?? '',
        'local' => $_POST['local'] ?? '',
        'tipo_tecnologia_id' => $_POST['tipo_tecnologia_id'] ?? 0
    ];
    
    $resultado = $controller->criarEvento($dadosEvento);
    
    if ($resultado) {
        $mensagem = "<div style='color: green;'>Evento criado com sucesso! ID: " . $resultado . "</div>";
    } else {
        $mensagem = "<div style='color: red;'>Erro ao criar evento. Verifique os dados informados.</div>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Criar Novo Evento</title>
</head>
<body>
    <h1>Criar Novo Evento</h1>
    
    <?php echo $mensagem; ?>
    
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
            <input type="number" name="tipo_tecnologia_id" id="tipo_tecnologia_id" min="1" required>
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