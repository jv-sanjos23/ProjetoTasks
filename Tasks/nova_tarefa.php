<?php
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_POST) {
    $titulo = $_POST['titulo'];
    $hora = $_POST['hora'];
    $data = $_POST['data'];
    $prioridade = $_POST['prioridade'];
    $descricao = $_POST['descricao'];

    $stmt = $conn->prepare("
        INSERT INTO tarefas (usuario_id, titulo, horario, data, prioridade, descricao) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("isssss", $_SESSION['user_id'], $titulo, $hora, $data, $prioridade, $descricao);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Tarefa</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container" style="position: relative;">

    <!-- BOTÃO VOLTAR -->
    <a href="index.php" class="voltar">←</a>

    <h1 class="titulo-pagina">ADICIONAR TAREFA</h1>
    <p class="subtitulo">Seu "eu do futuro" agradece os detalhes!</p>

    <form method="POST">

        <input class="input" name="titulo" placeholder="Título da Tarefa:" required>

        <div class="select-wrapper">
            <select name="prioridade">
                <option value="trivial">Trivial</option>
                <option value="importante">Importante</option>
                
            </select>
        </div>

        <div class="linha">
            <input class="input" type="time" class="input" name="hora" required>
            <input class="input" type="date" class="input" name="data" min="<?= date('Y-m-d') ?>"required>
        </div>

        <textarea class="input" name="descricao" placeholder="Descrição da Tarefa (Opcional):"></textarea>

        <button class="btn-criar">CRIAR</button>

    </form>

</div>

</body>
</html>