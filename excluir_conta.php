<?php

session_start();

require "config/conexao.php";

$id = $_SESSION["usuario_id"];

$sql = "DELETE FROM usuarios WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":id", $id);
$stmt->execute();

session_destroy();

header("Location: index.php");

?>