<?php

include "config.php";

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* BUSCAR CONFIGURAÇÕES */

$config = $conn->query("
SELECT * FROM configuracoes
WHERE usuario_id = $user_id
")->fetch_assoc();

/* ALTERAR LIMITE */

if(isset($_POST['limite_visual'])){

    $limite = intval($_POST['limite_visual']);

    $quantidade = intval($_POST['quantidade_tarefas']);

    $conn->query("
    UPDATE configuracoes

    SET 

    limite_visual = $limite,

    quantidade_tarefas = $quantidade

    WHERE usuario_id = $user_id
    ");

    header("Location: configuracoes.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Configurações</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="config-body">
<div class="config-container">
    <!-- TOPO -->
    <div class="config-topo">
        <div class="perfil-config">
            <img src="images/usuario.png" class="foto-perfil">
            <h2><?= $_SESSION['nome'] ?></h2>
        </div>
        <a href="index.php" class="btn-voltar">
            ←
        </a>
    </div>

    <!-- MENU -->
    <div class="config-menu">
        <a href="#" class="item-config">
            CONTA
        </a>
        <a href="#" class="item-config">
            NOTIFICAÇÕES
        </a>
        <a href="#" class="item-config">
            SOBRE NÓS
        </a>
        <!-- LIMITE VISUAL -->
        <button class="item-config btn-limite" id="abrirModal">
            LIMITE DE TAREFAS VISUAIS
        </button>

        <div class="linha-config"></div>

        <a href="logout.php" class="sair">
            SAIR DA CONTA
        </a>

    </div>

</div>

<!-- MODAL -->
<div class="modal" id="modalLimite">
    <div class="modal-box">
        <h2>Limite de tarefas</h2>
        <form method="POST">
            <p>
                Deseja ativar o limite de tarefas
                exibidas na tela inicial?
            </p>
            <select name="limite_visual" class="input">
                <option value="0"
                <?= !$config['limite_visual'] ? 'selected' : '' ?>>
                    Desativado
                </option>
                <option value="1"
                <?= $config['limite_visual'] ? 'selected' : '' ?>>
                    Ativado
                </option>
            </select>
            <p>
                Quantidade de tarefas visuais:
            </p>
            <input
            type="number"
            name="quantidade_tarefas"
            min="1"
            max="20"
            value="<?= $config['quantidade_tarefas'] ?>"
            class="input">
            <button class="btn-sim">
                SALVAR
            </button>
        </form>
        <button class="btn-fechar" id="fecharModal">
            CANCELAR
        </button>
    </div>
</div>

<!-- MENU INFERIOR -->

<nav class="menu">
    <a href="index.php" style="color: black; text-decoration: none;"><i class="fa-solid fa-house"></i></a>
    <i class="fa-solid fa-folder"></i>
    <a href="nova_tarefa.php">
        <button class="add" id="btnAdd">+</button>
    </a>
   <a href="pomodoro.php" style="color: black; text-decoration: none;"><i class="fa-solid fa-clock"></i></a>
    <a href="configuracoes.php" style="color: black; text-decoration: none;"><i class="fa-solid fa-gear"></i></a>
</nav>

<script>

const modal = document.getElementById("modalLimite");

document.getElementById("abrirModal")
.addEventListener("click", function(){

    modal.style.display = "flex";

});

document.getElementById("fecharModal")
.addEventListener("click", function(){

    modal.style.display = "none";

});

const botao = document.getElementById("btnAdd");
botao.addEventListener("mouseover", function(){
    botao.style.transform = "translateX(-50%) scale(1.2)";
});
botao.addEventListener("mouseout", function(){
    botao.style.transform = "translateX(-50%) scale(1)";

});

</script>

</body>
</html>
