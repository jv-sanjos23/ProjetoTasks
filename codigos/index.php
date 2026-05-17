<?php
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* CONCLUIR */
if (isset($_GET['concluir'])) {
    $id = intval($_GET['concluir']);
    $conn->query("UPDATE tarefas SET concluida = 1 WHERE id = $id AND usuario_id = $user_id");
}

/* EXCLUIR */
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM tarefas WHERE id = $id AND usuario_id = $user_id");
}

/* LISTAR */
$tarefas = $conn->query("SELECT * FROM tarefas WHERE usuario_id = $user_id ORDER BY horario ASC");

$data = date("d \\d\\e F, Y");
$dia = strtoupper(strftime("%A"));
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarefas</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

<header>
    <div>
        <h1><?= $dia ?></h1>
        <p><?= $data ?></p>
    </div>
    <div class="perfil"></div>
</header>

<section class="tarefas">
<?php while($t = $tarefas->fetch_assoc()): ?>
    <div class="card <?= ($t['prioridade'] == 'importante') ? 'importante' : '' ?>">
        
        <h2><?= $t['titulo'] ?></h2>

        <span>
            <?= $t['data'] ?> - <?= $t['horario'] ?>
        </span>


        <?php if($t['prioridade'] == 'importante'): ?>
            <span class="badge">Importante</span>
        <?php endif; ?>

        <div class="acoes">
            <a href="?concluir=<?= $t['id'] ?>">
                <button class="ok">✔</button>
            </a>

            <a href="?excluir=<?= $t['id'] ?>">
                <button class="cancel">✖</button>
            </a>
        </div>

    </div>
<?php endwhile; ?>
</section>

<div class="sequencia">
    <span>SEQUÊNCIA DE TAREFAS: <b>2</b></span>
    <div class="barra"></div>
</div>

</div>

<nav class="menu">
    <span>🏠</span>
    <span>📂</span>
    
    <!-- BOTÃO QUE VAI PRA OUTRA TELA -->
    <a href="nova_tarefa.php">
        <button class="add">+</button>
    </a>

    <span>⏱</span>
    <span>⚙</span>
</nav>

</body>
</html>
