<?php
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$config = $conn->query("
SELECT * FROM configuracoes
WHERE usuario_id = $user_id
")->fetch_assoc();

/* CONCLUIR */
if (isset($_GET['concluir'])) {

    $id = intval($_GET['concluir']);

    // verifica se já estava concluída
    $verifica = $conn->query("
    SELECT concluida

    FROM tarefas

    WHERE id = $id
    AND usuario_id = $user_id
    ");

    $tarefa = $verifica->fetch_assoc();

    if($tarefa && !$tarefa['concluida']){

        // conclui tarefa
        $conn->query("
        UPDATE tarefas

        SET concluida = 1

        WHERE id = $id
        AND usuario_id = $user_id
        ");

        // soma sequência
        $conn->query("
        UPDATE usuarios

        SET tarefas_concluidas = tarefas_concluidas + 1

        WHERE id = $user_id
        ");
    }
}

// total concluído
$user = $conn->query("
SELECT tarefas_concluidas, nome

FROM usuarios

WHERE id = $user_id
")->fetch_assoc();

$total = $user['tarefas_concluidas'];

// pega próxima fase
$fase = $conn->query("
SELECT *

FROM fases

WHERE quantidade > $total

ORDER BY quantidade ASC

LIMIT 1
")->fetch_assoc();

/* EXCLUIR */
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM tarefas WHERE id = $id AND usuario_id = $user_id");
}

/* LISTAR */
$sql = "
SELECT * FROM tarefas
WHERE usuario_id = $user_id
ORDER BY horario ASC
";

if($config['limite_visual']){

    $limite = intval($config['quantidade_tarefas']);

    $sql .= " LIMIT $limite";
}

$tarefas = $conn->query("
    SELECT * FROM tarefas 
    WHERE usuario_id = $user_id 
    AND concluida = 0
    ORDER BY horario ASC
");

date_default_timezone_set('America/Sao_Paulo');

setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');

$dia = strtoupper(strftime('%A'));

$data = strftime('%d de %B, %Y.');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarefas</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="container">

<header>
    <div>
        <h1><?= $dia ?></h1>
        <p><?= $data ?></p>
    </div>
    <div class="perfil-box">

    <span class="nome-user">
        <?= $_SESSION['nome'] ?>
    </span>

    <img src="images/usuario.png" class="foto-user">

</div>
</header>

<section class="tarefas">
<?php while($t = $tarefas->fetch_assoc()): ?>
    <div 
class="card <?= ($t['prioridade'] == 'importante') ? 'importante' : '' ?>"

data-titulo="<?= $t['titulo'] ?>"
data-data="<?= $t['data'] ?>"
data-horario="<?= $t['horario'] ?>"
data-prioridade="<?= $t['prioridade'] ?>"
data-descricao="<?= $t['descricao'] ?>"
>
        
        <h2><?= $t['titulo'] ?></h2>

        <span>
            <?= $t['data'] ?> - <?= $t['horario'] ?>
        </span>


        <?php if($t['prioridade'] == 'importante'): ?>
            <span class="badge">Importante</span>
        <?php endif; ?>

        <div class="acoes">
            <a href="?concluir=<?= $t['id'] ?>" onclick="event.stopPropagation()">
                <button class="ok efeito-btn">✔</button>
            </a>

            <a href="?excluir=<?= $t['id'] ?>" onclick="event.stopPropagation()">
                <button class="cancel efeito-btn">✖</button>
            </a>
        </div>

    </div>
<?php endwhile; ?>
</section>

<?php

$atual = $total;

$meta = $fase ? $fase['quantidade'] : $total;

$porcentagem = ($atual / $meta) * 100;

if($porcentagem > 100){
    $porcentagem = 100;
}
?>

<div class="sequencia">

    <span>
        <?= $fase['nome'] ?? 'TODAS AS FASES COMPLETAS' ?>
    </span>

    <p>
        <?= $atual ?> / <?= $meta ?> tarefas
    </p>

    <div class="barra">

        <div
        class="progresso"

        style="width:<?= $porcentagem ?>%">
        </div>

    </div>

</div>

</div>

<nav class="menu">
    <a href="index.php" style="color: black; text-decoration: none;"><i class="fa-solid fa-house"></i></a>
    <i class="fa-solid fa-folder"></i>
    
    <!-- BOTÃO QUE VAI PRA OUTRA TELA -->
    <a href="nova_tarefa.php">
        <button class="add" id="btnAdd">+</button>
    </a>

    <a href="pomodoro.php" style="color: black; text-decoration: none;"><i class="fa-solid fa-clock"></i></a>
    <a href="configuracoes.php" style="color: black; text-decoration: none;"><i class="fa-solid fa-gear"></i></a>
</nav>

<!-- MODAL -->

<div class="modal" id="modal">

    <div class="modal-box">

        <button class="fechar" id="fecharModal">
            ✖
        </button>

        <h2 id="modalTitulo"></h2>
        <p>
            <b>Data:</b>
            <span id="modalData"></span>
        </p>
        <p>
            <b>Horário:</b>
            <span id="modalHorario"></span>
        </p>
        <p>
            <b>Prioridade:</b>
            <span id="modalPrioridade"></span>
        </p>
        <p>
            <b>Descrição:</b>
            <span id="modalDescricao"></span>
        </p>
    </div>

</div>

<script>

const cards = document.querySelectorAll(".card");
const modal = document.getElementById("modal");
const fechar = document.getElementById("fecharModal");

cards.forEach(function(card){

    card.addEventListener("click", function(){

        document.getElementById("modalTitulo").innerText =
        card.dataset.titulo;

        document.getElementById("modalData").innerText =
        card.dataset.data;

        document.getElementById("modalHorario").innerText =
        card.dataset.horario;

        document.getElementById("modalPrioridade").innerText =
        card.dataset.prioridade;

        document.getElementById("modalDescricao").innerText =
        card.dataset.descricao;

        modal.style.display = "flex";

    });

});

fechar.addEventListener("click", function(){

    modal.style.display = "none";

});

</script>

</body>

<script>
const botoes = document.querySelectorAll(".efeito-btn");
botoes.forEach(function(botao){
    botao.addEventListener("mouseover", function(){
        botao.style.transform = "scale(1.2)";
    });
    botao.addEventListener("mouseout", function(){
        botao.style.transform = "scale(1)";
    });
});    
const botao = document.getElementById("btnAdd");
botao.addEventListener("mouseover", function(){
    botao.style.transform = "translateX(-50%) scale(1.2)";
});
botao.addEventListener("mouseout", function(){
    botao.style.transform = "translateX(-50%) scale(1)";

});
</script>

</html>
