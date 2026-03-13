<?php

require "config/verifica_login.php";
require "config/conexao.php";

$tipo = $_SESSION["usuario_tipo"];

$id = $_POST["id"];

/*
========================
BUSCAR ORDEM ATUAL
========================
*/

$sql = "SELECT * FROM ordens WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id",$id);
$stmt->execute();

$ordem = $stmt->fetch(PDO::FETCH_ASSOC);


/*
========================
DADOS DO FORMULÁRIO
========================
*/

$descricao = $_POST["descricao"] ?? $ordem["descricao"];
$prioridade = $_POST["prioridade"] ?? $ordem["prioridade"];
$status = $_POST["status"] ?? $ordem["status"];
$tecnico_id = $_POST["tecnico_id"] ?? $ordem["tecnico_id"];
$observacao_tecnico = $_POST["observacao_tecnico"] ?? $ordem["observacao_tecnico"];


/*
========================
CONTROLE DE PERMISSÃO
========================
*/

if($tipo == "usuario"){

    // usuário só pode alterar descrição e prioridade
    $status = $ordem["status"];
    $tecnico_id = $ordem["tecnico_id"];
    $observacao_tecnico = $ordem["observacao_tecnico"];

}

elseif($tipo == "tecnico"){

    // técnico só pode alterar status e observação
    $descricao = $ordem["descricao"];
    $prioridade = $ordem["prioridade"];
    $tecnico_id = $ordem["tecnico_id"];

}

elseif($tipo == "admin"){

    // admin pode alterar tudo
}


/*
========================
DATA DE CONCLUSÃO
========================
*/

$data_conclusao = $ordem["data_conclusao"];

if($status == "concluida" && $ordem["data_conclusao"] == null){

    $data_conclusao = date("Y-m-d H:i:s");

}


/*
========================
UPDATE
========================
*/

$sql = "UPDATE ordens SET

descricao = :descricao,
prioridade = :prioridade,
status = :status,
tecnico_id = :tecnico_id,
observacao_tecnico = :observacao_tecnico,
data_conclusao = :data_conclusao

WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(":descricao",$descricao);
$stmt->bindParam(":prioridade",$prioridade);
$stmt->bindParam(":status",$status);
$stmt->bindParam(":tecnico_id",$tecnico_id);
$stmt->bindParam(":observacao_tecnico",$observacao_tecnico);
$stmt->bindParam(":data_conclusao",$data_conclusao);
$stmt->bindParam(":id",$id);

$stmt->execute();


/*
========================
REDIRECIONAR
========================
*/

header("Location: ordens.php");
exit;

?>