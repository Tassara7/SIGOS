<?php

require "config/verifica_login.php";
require "config/conexao.php";

/* apenas admin pode excluir */

if($_SESSION["usuario_tipo"] != "admin"){

header("Location: dashboard.php");
exit;

}

$id = $_GET["id"];

$sql = "DELETE FROM ordens WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: ordens.php");

?>