<?php
$conn = new mysqli("localhost", "root", "", "tarefas_app");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

session_start();
?>
