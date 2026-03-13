<?php

session_start();

require "config/conexao.php";

$email = $_POST["email"];
$senha = $_POST["senha"];

$sql = "SELECT * FROM usuarios WHERE email = :email";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":email", $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha, $usuario["senha"])) {

    $_SESSION["usuario_id"] = $usuario["id"];
    $_SESSION["usuario_nome"] = $usuario["nome"];
    $_SESSION["usuario_tipo"] = $usuario["tipo"];

    header("Location: dashboard.php");
    exit();

} else {

    header("Location: login.php?erro=1");
    exit();

}

?>