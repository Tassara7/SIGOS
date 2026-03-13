<?php

session_start();

require "config/conexao.php";

$id = $_POST["id"];
$nome = $_POST["nome"];

$sql = "UPDATE usuarios SET nome = :nome WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":id", $id);

$stmt->execute();

/* atualizar nome na sessão */

$_SESSION["usuario_nome"] = $nome;

header("Location: perfil.php");

?>