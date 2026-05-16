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
