<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        die("Email não encontrado.");
    }

    $token = bin2hex(random_bytes(32));

    $sql = "UPDATE usuarios 
            SET reset_token = ?, 
                token_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR)
            WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    $link = "http://localhost/Tasks/redefinir_senha.php?token=" . $token;

    echo "Clique para redefinir sua senha:<br>";
    echo "<a href='$link'>$link</a>";
    exit;
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Seu email" required>
    <button type="submit">Recuperar senha</button>
</form>