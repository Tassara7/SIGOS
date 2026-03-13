<?php

$pagina = "ordens";

require "config/verifica_login.php";
require "config/conexao.php";

$busca = $_GET["busca"] ?? "";
$statusFiltro = $_GET["status"] ?? "";
$prioridadeFiltro = $_GET["prioridade"] ?? "";

$where = [];
$params = [];

if($busca){
    $where[] = "ordens.titulo LIKE :busca";
    $params["busca"] = "%$busca%";
}

if($statusFiltro){
    $where[] = "ordens.status = :status";
    $params["status"] = $statusFiltro;
}

if($prioridadeFiltro){
    $where[] = "ordens.prioridade = :prioridade";
    $params["prioridade"] = $prioridadeFiltro;
}

/* CONTROLE DE VISUALIZACAO */

if($_SESSION["usuario_tipo"] == "usuario"){
    $where[] = "ordens.usuario_id = :usuario_id";
    $params["usuario_id"] = $_SESSION["usuario_id"];
}

if($_SESSION["usuario_tipo"] == "tecnico"){
    $where[] = "ordens.tecnico_id = :tecnico_id";
    $params["tecnico_id"] = $_SESSION["usuario_id"];
}

$whereSQL = "";

if(count($where) > 0){
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

$sql = "SELECT ordens.*,
usuarios.nome AS usuario_nome,
tecnico.nome AS tecnico_nome

FROM ordens

JOIN usuarios
ON ordens.usuario_id = usuarios.id

LEFT JOIN usuarios AS tecnico
ON ordens.tecnico_id = tecnico.id

$whereSQL

ORDER BY data_abertura DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<h2>Ordens de Serviço</h2>

<a href="nova_ordem.php" class="btn btn-success mb-3">
+ Nova Ordem
</a>

<!-- FILTROS -->

<div class="mb-4">

<h5>Filtro:</h5>

<strong>Por status:</strong><br>

<a href="ordens.php" class="btn <?= ($statusFiltro==""?"btn-dark":"btn-secondary"); ?>">Todas</a>

<a href="ordens.php?status=aberta" class="btn <?= ($statusFiltro=="aberta"?"btn-dark":"btn-danger"); ?>">Abertas</a>

<a href="ordens.php?status=em andamento" class="btn <?= ($statusFiltro=="em andamento"?"btn-dark":"btn-warning"); ?>">Em andamento</a>

<a href="ordens.php?status=concluida" class="btn <?= ($statusFiltro=="concluida"?"btn-dark":"btn-success"); ?>">Concluídas</a>

<br><br>

<strong>Por prioridade:</strong><br>

<a href="ordens.php" class="btn <?= ($prioridadeFiltro==""?"btn-dark":"btn-secondary"); ?>">Todas</a>

<a href="ordens.php?prioridade=alta" class="btn <?= ($prioridadeFiltro=="alta"?"btn-dark":"btn-danger"); ?>">Alta</a>

<a href="ordens.php?prioridade=media" class="btn <?= ($prioridadeFiltro=="media"?"btn-dark":"btn-warning"); ?>">Média</a>

<a href="ordens.php?prioridade=baixa" class="btn <?= ($prioridadeFiltro=="baixa"?"btn-dark":"btn-success"); ?>">Baixa</a>

</div>

<!-- BUSCA -->

<form method="GET" class="mb-3">

<input type="text" id="inputBusca" name="busca" class="form-control"
placeholder="Buscar ordem pelo título"
value="<?= $busca ?>"
data-status="<?= htmlspecialchars($statusFiltro) ?>"
data-prioridade="<?= htmlspecialchars($prioridadeFiltro) ?>">

<button class="btn btn-primary mt-2">
Buscar
</button>

</form>

<!-- TABELA -->

<table class="table table-bordered">

<thead>

<tr>
<th>ID</th>
<th>Título</th>
<th>Usuário</th>
<th>Técnico</th>
<th>Prioridade</th>
<th>Status</th>
<th>Data</th>
<th>Ações</th>
</tr>

</thead>

<tbody id="corpoTabela">

<?php foreach($ordens as $ordem): ?>

<tr>

<td><?= $ordem["id"] ?></td>

<td>
<a href="ver_ordem.php?id=<?= $ordem["id"] ?>">
<?= $ordem["titulo"] ?>
</a>
</td>

<td><?= $ordem["usuario_nome"] ?></td>

<td>

<?php
if($ordem["tecnico_nome"]){
echo $ordem["tecnico_nome"];
}else{
echo "<span class='text-muted'>Não atribuído</span>";
}
?>

</td>

<td>

<?php

$p = $ordem["prioridade"];

if($p == "alta"){
echo "<span class='badge bg-danger'>Alta</span>";
}
elseif($p == "media"){
echo "<span class='badge bg-warning text-dark'>Média</span>";
}
else{
echo "<span class='badge bg-secondary'>Baixa</span>";
}

?>

</td>

<td>

<?php

$status = $ordem["status"];

if($status == "aberta"){
echo "<span class='badge bg-danger'>Aberta</span>";
}
elseif($status == "em andamento"){
echo "<span class='badge bg-warning text-dark'>Em andamento</span>";
}
elseif($status == "concluida"){
echo "<span class='badge bg-success'>Concluída</span>";
}

?>

</td>

<td><?= $ordem["data_abertura"] ?></td>

<td>

<a href="editar_ordem.php?id=<?= $ordem["id"] ?>" class="btn btn-sm btn-warning">
Editar
</a>

<?php if($_SESSION["usuario_tipo"] == "admin"): ?>

<a href="excluir_ordem.php?id=<?= $ordem["id"] ?>"
class="btn btn-sm btn-danger"
data-confirm="Deseja excluir esta ordem?">

Excluir

</a>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php include "includes/footer.php"; ?>