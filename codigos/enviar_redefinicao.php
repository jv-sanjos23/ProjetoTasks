<?php

include("config.php");

$email = $_POST['email'];

$sql = "SELECT * FROM usuarios WHERE email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    $token = bin2hex(random_bytes(32));

    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $update = "UPDATE usuarios 
               SET reset_token = ?, token_expira = ?
               WHERE email = ?";

    $stmtUpdate = $conn->prepare($update);

    $stmtUpdate->bind_param("sss", $token, $expira, $email);

    $stmtUpdate->execute();

    $link = "http://localhost/Tasks/redefinir_senha.php?token=$token";

    echo "

    <h2>Link de recuperação:</h2>

    <a href='$link'>

        $link

    </a>

    ";

}else{

    echo "Email não encontrado.";

}

?>
