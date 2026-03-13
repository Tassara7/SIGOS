<?php

require "config/verifica_login.php";
require "config/conexao.php";

$busca = isset($_GET["busca"]) ? $_GET["busca"] : "";
$statusFiltro = isset($_GET["status"]) ? $_GET["status"] : "";
$prioridadeFiltro = isset($_GET["prioridade"]) ? $_GET["prioridade"] : "";

$where = [];
$params = [];

if ($busca) {
    $where[] = "ordens.titulo LIKE :busca";
    $params["busca"] = "%" . $busca . "%";
}

if ($statusFiltro) {
    $where[] = "ordens.status = :status";
    $params["status"] = $statusFiltro;
}

if ($prioridadeFiltro) {
    $where[] = "ordens.prioridade = :prioridade";
    $params["prioridade"] = $prioridadeFiltro;
}

// controle de acesso por tipo de usuario
if ($_SESSION["usuario_tipo"] == "usuario") {
    $where[] = "ordens.usuario_id = :uid";
    $params["uid"] = $_SESSION["usuario_id"];
}

if ($_SESSION["usuario_tipo"] == "tecnico") {
    $where[] = "ordens.tecnico_id = :uid";
    $params["uid"] = $_SESSION["usuario_id"];
}

$whereSQL = "";
if (count($where) > 0) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

$sql = "SELECT ordens.*, usuarios.nome AS usuario_nome, tecnico.nome AS tecnico_nome
        FROM ordens
        JOIN usuarios ON ordens.usuario_id = usuarios.id
        LEFT JOIN usuarios AS tecnico ON ordens.tecnico_id = tecnico.id
        $whereSQL
        ORDER BY data_abertura DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($ordens);
