<?php
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$user = $conn->query("
SELECT nome
FROM usuarios
WHERE id = $user_id
")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pomodoro Timer</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body class="timer-body">

<div class="timer-container">

    <!-- TOPO -->

    <div class="timer-topo">

        <div>

            <h1>Pomodoro timer</h1>

            <p>
                Pomodoro Timer ajuda a manter foco
                com pausas estratégicas!
            </p>

        </div>

        <a href="index.php" class="btn-voltar-timer">

            ←

        </a>

    </div>

    <!-- TIMER -->

    <div class="timer-box">

        <div class="circulo-timer">

            <svg>

                <circle cx="120" cy="120" r="100"></circle>

                <circle 
                cx="120" 
                cy="120" 
                r="100"

                id="progresso">
                </circle>

            </svg>

            <div class="tempo">

                <span id="minutos">

                    25

                </span>

                <small>min</small>

            </div>

        </div>

        <!-- BOTÃO -->

        <button id="btnPlay" class="btn-play">

            ▶

        </button>

        <!-- INDICADORES -->

        <div class="pontos">

            <span class="ativo"></span>
            <span></span>
            <span></span>
            <span></span>

        </div>

        <p class="frase">

            FOCO NO AGORA. O RESTO ESPERA!

        </p>

    </div>

</div>

<!-- MENU -->

<nav class="menu">

    <a href="index.php">
        <span>🏠</span>
    </a>

    <span>📂</span>

    <a href="nova_tarefa.php">
        <button class="add">+</button>
    </a>

    <a href="pomodoro.php" style="color: black; text-decoration: none;"><span>⏱</span></a>
    <a href="configuracoes.php" style="color: black; text-decoration: none;"><span >⚙</span></a>

</nav>

<script>

let tempo = 25 * 60;

let rodando = false;

let intervalo;

const minutos = document.getElementById("minutos");

const btn = document.getElementById("btnPlay");

const progresso = document.getElementById("progresso");

const total = 2 * Math.PI * 100;

progresso.style.strokeDasharray = total;

progresso.style.strokeDashoffset = 0;

btn.addEventListener("click", () => {

    if(!rodando){

        rodando = true;

        btn.innerHTML = "❚❚";

        intervalo = setInterval(timer, 1000);

    } else {

        rodando = false;

        btn.innerHTML = "▶";

        clearInterval(intervalo);
    }

});

function timer(){

    tempo--;
    let min = Math.floor(tempo / 60);
    minutos.innerHTML = min;
    let porcentagem = tempo / (25 * 60);

    progresso.style.strokeDashoffset =
    total - (total * porcentagem);

    if(tempo <= 0){
        clearInterval(intervalo);
        btn.innerHTML = "▶";
        alert("Tempo finalizado!");
    }
}

</script>

</body>
</html>
