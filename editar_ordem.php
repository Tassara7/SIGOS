<?php

$pagina = "ordens";

require "config/verifica_login.php";
require "config/conexao.php";

$tipo = $_SESSION["usuario_tipo"];

$id = $_GET["id"];

$sql = "SELECT * FROM ordens WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id",$id);
$stmt->execute();

$ordem = $stmt->fetch(PDO::FETCH_ASSOC);

/* buscar tecnicos */

$sqlTec = "SELECT id,nome FROM usuarios WHERE tipo='tecnico'";
$stmtTec = $pdo->query($sqlTec);
$tecnicos = $stmtTec->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<h2>Atualizar Ordem</h2>

<form id="form-ordem" action="atualizar_ordem.php" method="POST">

<input type="hidden" name="id" value="<?= $ordem["id"] ?>">

<!-- DESCRICAO -->

<?php if($tipo == "usuario" || $tipo == "admin"): ?>

<div class="mb-3">
<label>Descrição</label>

<textarea name="descricao" class="form-control" rows="4"><?= $ordem["descricao"] ?></textarea>

</div>

<?php else: ?>

<input type="hidden" name="descricao" value="<?= $ordem["descricao"] ?>">

<?php endif; ?>


<!-- PRIORIDADE -->

<?php if($tipo == "usuario" || $tipo == "admin"): ?>

<div class="mb-3">

<label>Prioridade</label>

<select name="prioridade" class="form-control">

<option value="alta" <?= $ordem["prioridade"]=="alta"?"selected":"" ?>>Alta</option>

<option value="media" <?= $ordem["prioridade"]=="media"?"selected":"" ?>>Média</option>

<option value="baixa" <?= $ordem["prioridade"]=="baixa"?"selected":"" ?>>Baixa</option>

</select>

</div>

<?php else: ?>

<input type="hidden" name="prioridade" value="<?= $ordem["prioridade"] ?>">

<?php endif; ?>


<!-- STATUS -->

<?php if($tipo == "tecnico" || $tipo == "admin"): ?>

<div class="mb-3">

<label>Status</label>

<select name="status" class="form-control">

<option value="aberta" <?= $ordem["status"]=="aberta"?"selected":"" ?>>Aberta</option>

<option value="em andamento" <?= $ordem["status"]=="em andamento"?"selected":"" ?>>Em andamento</option>

<option value="concluida" <?= $ordem["status"]=="concluida"?"selected":"" ?>>Concluída</option>

</select>

</div>

<?php else: ?>

<input type="hidden" name="status" value="<?= $ordem["status"] ?>">

<?php endif; ?>


<!-- TECNICO RESPONSAVEL -->

<?php if($tipo == "admin"): ?>

<div class="mb-3">

<label>Técnico responsável</label>

<select name="tecnico_id" class="form-control">

<option value="">Não atribuído</option>

<?php foreach($tecnicos as $tec): ?>

<option value="<?= $tec["id"] ?>" <?= $ordem["tecnico_id"]==$tec["id"]?"selected":"" ?>>

<?= $tec["nome"] ?>

</option>

<?php endforeach; ?>

</select>

</div>

<?php else: ?>

<input type="hidden" name="tecnico_id" value="<?= $ordem["tecnico_id"] ?>">

<?php endif; ?>


<!-- OBSERVACAO TECNICO (SOMENTE ADMIN) -->

<?php if($tipo == "admin"): ?>

<div class="mb-3">

<label>Observação do técnico</label>

<textarea name="observacao_tecnico" class="form-control" rows="4"><?= $ordem["observacao_tecnico"] ?></textarea>

</div>

<?php else: ?>

<input type="hidden" name="observacao_tecnico" value="<?= $ordem["observacao_tecnico"] ?>">

<?php endif; ?>


<button class="btn btn-primary">
Atualizar
</button>

</form>

</div>

<?php include "includes/footer.php"; ?>