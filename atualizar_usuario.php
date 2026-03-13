<?php
require "config/verifica_login.php";
require "config/conexao.php";

if($_SESSION["usuario_tipo"] != "admin"){
    header("Location: dashboard.php");
    exit;
}

$id = $_POST["id"];
$nome = $_POST["nome"];
$email = $_POST["email"];
$tipo = $_POST["tipo"];

$sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":tipo", $tipo);
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: usuarios.php");
exit;
?>