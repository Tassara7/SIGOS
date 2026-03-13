<?php

session_start();

require "config/conexao.php";

$titulo = $_POST["titulo"];
$descricao = $_POST["descricao"];
$prioridade = $_POST["prioridade"];

$usuario_id = $_SESSION["usuario_id"];

$sql = "INSERT INTO ordens
(titulo, descricao, prioridade, usuario_id, status, data_abertura)

VALUES
(:titulo, :descricao, :prioridade, :usuario_id, 'aberta', NOW())";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":titulo", $titulo);
$stmt->bindParam(":descricao", $descricao);
$stmt->bindParam(":prioridade", $prioridade);
$stmt->bindParam(":usuario_id", $usuario_id);

$stmt->execute();

header("Location: ordens.php");

?>