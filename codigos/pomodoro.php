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
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                <!-- FUNDO -->
                <circle
                    cx="120"
                    cy="120"
                    r="100">
                </circle>
                <!-- PROGRESSO -->
                <circle 
                    cx="120" 
                    cy="120" 
                    r="100"
                    id="progresso">
                </circle>
            </svg>
            <div class="tempo">
                <span id="tempoTexto">
                    25:00
                </span>

               <small id="modo">
                    foco
                </small>
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
        <p class="frase" id="frase">
            FOCO NO AGORA. O RESTO ESPERA!
        </p>
    </div>
</div>
<!-- MENU -->
<nav class="menu">
    <a href="index.php" style="color: black; text-decoration: none;">
        <i class="fa-solid fa-house"></i>
    </a>
    <i class="fa-solid fa-folder"></i>
    <a href="nova_tarefa.php">
        <button class="add" id="btnAdd">+</button>
    </a>
    <a href="pomodoro.php" style="color: black; text-decoration: none;">
        <i class="fa-solid fa-clock"></i>
    </a>
    <a href="configuracoes.php" style="color: black; text-decoration: none;">
        <i class="fa-solid fa-gear"></i>
    </a>
</nav>
<script>
/* TEMPOS */
const tempoFoco = 25 * 60;
const tempoPausa = 5 * 60;
/* VARIÁVEIS */
let tempo = tempoFoco;
let rodando = false;
let intervalo;
let ciclo = 1;
let pausa = false;
/* ELEMENTOS */
const tempoTexto = document.getElementById("tempoTexto");
const btn = document.getElementById("btnPlay");
const progresso = document.getElementById("progresso");
const frase = document.getElementById("frase");
const modo = document.getElementById("modo");
const pontos = document.querySelectorAll(".pontos span");
/* CÍRCULO */
const radius = 100;
const total = 2 * Math.PI * radius;
progresso.style.strokeDasharray = total;
progresso.style.strokeDashoffset = 0;
/* ATUALIZAR TELA */
function atualizarTela(){
    let min = Math.floor(tempo / 60);
    let seg = tempo % 60;
    if(min < 10){
        min = "0" + min;
    }
    if(seg < 10){
        seg = "0" + seg;
    }
    tempoTexto.innerHTML = `${min}:${seg}`;
    let tempoAtual = pausa ? tempoPausa : tempoFoco;
    let porcentagem = tempo / tempoAtual;
    progresso.style.strokeDashoffset =
        total - (total * porcentagem);
}
/* TIMER */
function iniciarTimer(){
    intervalo = setInterval(() => {
        tempo--;
        atualizarTela();
        if(tempo <= 0){
            clearInterval(intervalo);
            /* TERMINOU FOCO */
            if(!pausa){
                pausa = true;
                tempo = tempoPausa;
                frase.innerHTML = "Hora da pausa!";
                modo.innerHTML = "pausa";
                iniciarTimer();
            }
            /* TERMINOU PAUSA */
            else{
                ciclo++;
                if(ciclo > 4){
                    frase.innerHTML = "Pomodoro finalizado!";
                    modo.innerHTML = "fim";
                    btn.innerHTML = "↻";
                    rodando = false;
                    return;
                }
                pausa = false;
                tempo = tempoFoco;
                frase.innerHTML = `Ciclo ${ciclo} de 4`;
                modo.innerHTML = "foco";
                atualizarPontos();
                iniciarTimer();
            }
        }
    }, 1000);
}
/* PLAY / PAUSE */
btn.addEventListener("click", () => {
    /* REINICIAR */
    if(ciclo > 4){
        ciclo = 1;
        pausa = false;
        tempo = tempoFoco;
        frase.innerHTML = "FOCO NO AGORA. O RESTO ESPERA!";
        modo.innerHTML = "foco";
        atualizarPontos();
        atualizarTela();
        btn.innerHTML = "▶";
    }
    /* PLAY */
    if(!rodando){
        rodando = true;
        btn.innerHTML = "❚❚";
        iniciarTimer();
    }
    /* PAUSE */
    else{
        rodando = false;
        btn.innerHTML = "▶";
        clearInterval(intervalo);
    }
});
/* CICLOS */
function atualizarPontos(){
    pontos.forEach((ponto, index) => {
        ponto.classList.remove("ativo");
        if(index < ciclo){
            ponto.classList.add("ativo");
        }
    });

}
/* INICIAL */

atualizarTela();

</script>

</body>


</html>
