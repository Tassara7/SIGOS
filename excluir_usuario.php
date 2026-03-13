<?php

session_start();

require "config/conexao.php";

$id = $_GET["id"];

/* verificar se usuario possui ordens */

$sql = "SELECT COUNT(*) FROM ordens
        WHERE usuario_id = :id
        OR tecnico_id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$total = $stmt->fetchColumn();

if($total > 0){

    header("Location: usuarios.php?erro=ordens");
    exit;

}

/* excluir usuario */

$sql = "DELETE FROM usuarios WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: usuarios.php");

?>