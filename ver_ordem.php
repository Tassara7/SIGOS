<?php

$pagina = "ordens";

require "config/verifica_login.php";
require "config/conexao.php";

$id = $_GET["id"];

$sql = "SELECT 
        ordens.*,
        usuarios.nome AS usuario_nome,
        tecnico.nome AS tecnico_nome

FROM ordens

JOIN usuarios 
ON ordens.usuario_id = usuarios.id

LEFT JOIN usuarios AS tecnico
ON ordens.tecnico_id = tecnico.id

WHERE ordens.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id",$id);
$stmt->execute();

$ordem = $stmt->fetch(PDO::FETCH_ASSOC);

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<a href="ordens.php" class="btn btn-light mb-3">
← Voltar para Ordens
</a>

<h2>Detalhes da Ordem #<?= $ordem["id"] ?></h2>

<div class="card mt-4">

<div class="card-body">

<p>
<strong>Título:</strong> 
<?= $ordem["titulo"] ?>
</p>

<p>
<strong>Descrição:</strong> 
<?= $ordem["descricao"] ?>
</p>

<p>
<strong>Usuário:</strong> 
<?= $ordem["usuario_nome"] ?>
</p>

<p>
<strong>Técnico:</strong> 
<?= $ordem["tecnico_nome"] ?? "Não atribuído" ?>
</p>

<p>
<strong>Prioridade:</strong> 
<?= $ordem["prioridade"] ?>
</p>

<p>
<strong>Status:</strong> 
<?= $ordem["status"] ?>
</p>

<p>
<strong>Data de abertura:</strong> 
<?= $ordem["data_abertura"] ?>
</p>

<p>
<strong>Observação do técnico:</strong> 
<?= $ordem["observacao_tecnico"] ?>
</p>

<a href="editar_ordem.php?id=<?= $ordem["id"] ?>" class="btn btn-primary mt-3">
Editar ordem
</a>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>