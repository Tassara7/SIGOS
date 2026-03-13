<?php

$pagina = "dashboard";

require "config/verifica_login.php";
require "config/conexao.php";

// dados do usuario logado
$tipo = $_SESSION["usuario_tipo"];
$usuario_id = $_SESSION["usuario_id"];
$nome = $_SESSION["usuario_nome"];

// filtro pra mostrar so as ordens do usuario ou tecnico
$filtro = "WHERE 1=1";

if ($tipo == "usuario") {
    $filtro .= " AND usuario_id = $usuario_id";
} elseif ($tipo == "tecnico") {
    $filtro .= " AND tecnico_id = $usuario_id";
}

// admin ve tudo, nao precisa de filtro

// contagens de status
$total     = $pdo->query("SELECT COUNT(*) FROM ordens $filtro")->fetchColumn();
$abertas   = $pdo->query("SELECT COUNT(*) FROM ordens $filtro AND status='aberta'")->fetchColumn();
$andamento = $pdo->query("SELECT COUNT(*) FROM ordens $filtro AND status='em andamento'")->fetchColumn();
$concluidas = $pdo->query("SELECT COUNT(*) FROM ordens $filtro AND status='concluida'")->fetchColumn();

// contagens de prioridade
$alta  = $pdo->query("SELECT COUNT(*) FROM ordens $filtro AND prioridade='alta'")->fetchColumn();
$media = $pdo->query("SELECT COUNT(*) FROM ordens $filtro AND prioridade='media'")->fetchColumn();
$baixa = $pdo->query("SELECT COUNT(*) FROM ordens $filtro AND prioridade='baixa'")->fetchColumn();

// titulo da pagina muda de acordo com o tipo de usuario
$titulo = "Dashboard";

if ($tipo == "usuario") {
    $titulo = "Minhas Solicitações";
} elseif ($tipo == "tecnico") {
    $titulo = "Minhas Ordens de Serviço";
} elseif ($tipo == "admin") {
    $titulo = "Painel Geral do Sistema";
}

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<h1><?= $titulo ?></h1>

<p>Bem-vindo <strong><?= $nome ?></strong></p>


<!-- cards de status -->

<div class="row mt-4">

<div class="col-md-3">

<a href="ordens.php" class="link-card">

<div class="card text-white bg-primary mb-3">

<div class="card-body">
<h5>Total</h5>
<h3><?= $total ?></h3>
</div>

</div>

</a>

</div>


<div class="col-md-3">

<a href="ordens.php?status=aberta" class="link-card">

<div class="card text-white bg-danger mb-3">

<div class="card-body">
<h5>Abertas</h5>
<h3><?= $abertas ?></h3>
</div>

</div>

</a>

</div>


<div class="col-md-3">

<a href="ordens.php?status=em andamento" class="link-card">

<div class="card text-dark bg-warning mb-3">

<div class="card-body">
<h5>Em andamento</h5>
<h3><?= $andamento ?></h3>
</div>

</div>

</a>

</div>


<div class="col-md-3">

<a href="ordens.php?status=concluida" class="link-card">

<div class="card text-white bg-success mb-3">

<div class="card-body">
<h5>Concluídas</h5>
<h3><?= $concluidas ?></h3>
</div>

</div>

</a>

</div>

</div>


<!-- prioridades -->

<h3 class="mt-4">Prioridades</h3>

<div class="row">

<div class="col-md-4">

<a href="ordens.php?prioridade=alta" class="link-card">

<div class="card text-white bg-danger mb-3">

<div class="card-body">
<h5>Alta</h5>
<h3><?= $alta ?></h3>
</div>

</div>

</a>

</div>


<div class="col-md-4">

<a href="ordens.php?prioridade=media" class="link-card">

<div class="card text-dark bg-warning mb-3">

<div class="card-body">
<h5>Média</h5>
<h3><?= $media ?></h3>
</div>

</div>

</a>

</div>


<div class="col-md-4">

<a href="ordens.php?prioridade=baixa" class="link-card">

<div class="card text-white bg-success mb-3">

<div class="card-body">
<h5>Baixa</h5>
<h3><?= $baixa ?></h3>
</div>

</div>

</a>

</div>

</div>


<!-- grafico de pizza -->

<h3 class="mt-5">Distribuição de Ordens</h3>

<canvas id="graficoOrdens"
    data-abertas="<?= $abertas ?>"
    data-andamento="<?= $andamento ?>"
    data-concluidas="<?= $concluidas ?>"></canvas>

</div>

<?php include "includes/footer.php"; ?>