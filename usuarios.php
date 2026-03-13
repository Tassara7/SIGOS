<?php

require "config/verifica_login.php";

if($_SESSION["usuario_tipo"] != "admin"){
header("Location: dashboard.php");
exit;
}

$pagina = "usuarios";

require "config/conexao.php";

include "includes/header.php";
include "includes/menu.php";

$sql = "SELECT id, nome, email, tipo FROM usuarios";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-5">

<h2>Usuários do Sistema</h2>

<?php if(isset($_GET["erro"])): ?>

<div class="alert alert-danger">
Não é possível excluir este usuário porque ele possui ordens registradas.
</div>

<?php endif; ?>

<a href="novo_usuario.php" class="btn btn-success mb-3">
+ Novo Usuário
</a>

<table class="table table-bordered table-striped">

<thead>

<tr>
<th>ID</th>
<th>Nome</th>
<th>Email</th>
<th>Tipo</th>
<th>Ações</th>
</tr>

</thead>

<tbody>

<?php foreach($usuarios as $usuario): ?>

<tr>

<td><?php echo $usuario["id"]; ?></td>

<td><?php echo htmlspecialchars($usuario["nome"]); ?></td>

<td><?php echo htmlspecialchars($usuario["email"]); ?></td>

<td>

<?php

if($usuario["tipo"] == "admin"){
echo "<span class='badge bg-danger'>Admin</span>";
}
elseif($usuario["tipo"] == "tecnico"){
echo "<span class='badge bg-warning text-dark'>Técnico</span>";
}
else{
echo "<span class='badge bg-secondary'>Usuário</span>";
}

?>

</td>

<td>

<a href="editar_usuario.php?id=<?php echo $usuario["id"]; ?>" class="btn btn-warning btn-sm">
Editar
</a>

<?php if($usuario["id"] != $_SESSION["usuario_id"]): ?>

<a href="excluir_usuario.php?id=<?php echo $usuario["id"]; ?>"
class="btn btn-danger btn-sm"
data-confirm="Tem certeza que deseja excluir este usuário?">

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