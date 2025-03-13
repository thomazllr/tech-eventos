<?php
require_once '../src/controller/EventoController.php';  
require_once '../src/dao/EventoDAO.php';  


$controller = new EventoController();
$eventos = [];
$eventos = $controller->listarEventos();
$eventoDAO = new EventoDAO();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: #333;
        }
        
        .filter {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .btn {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            margin-right: 5px;
        }
        
        .btn-view {
            background-color: #2196F3;
        }
        
        .btn-edit {
            background-color: #FFC107;
        }
        
        .btn-delete {
            background-color: #F44336;
        }
        
        .add-new {
            margin-top: 20px;
        }
        
        .add-new a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Lista de Eventos de Tecnologia</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Data Início</th>
                <th>Data Fim</th>
                <th>Local</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($eventos) > 0): ?>
                <?php foreach ($eventos as $evento): ?>
                <tr>
                    <td><?= $evento['id'] ?></td>
                    <td><?= $evento['titulo'] ?></td>
                    <td>
                        <?php
                            $nomeTecnologia = $eventoDAO->buscarNomeTecnologiaPorId($evento['tipo_tecnologia_id']);
                            echo $nomeTecnologia ? $nomeTecnologia : 'Tecnologia não encontrada';
                        ?>
                    </td>                    <td><?= date('d/m/Y H:i', strtotime($evento['data_inicio'])) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($evento['data_fim'])) ?></td>
                    <td><?= $evento['local'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum evento encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
