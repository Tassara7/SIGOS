<?php

require "config/verifica_login.php";
require "config/conexao.php";

if($_SESSION["usuario_tipo"] != "admin"){
header("Location: dashboard.php");
exit;
}

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
$tipo = $_POST["tipo"];

$sql = "INSERT INTO usuarios (nome,email,senha,tipo)
VALUES (:nome,:email,:senha,:tipo)";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":nome",$nome);
$stmt->bindParam(":email",$email);
$stmt->bindParam(":senha",$senha);
$stmt->bindParam(":tipo",$tipo);

$stmt->execute();

header("Location: usuarios.php");
exit;