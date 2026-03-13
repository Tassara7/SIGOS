<?php

$pagina = "perfil";

require "config/verifica_login.php";
require "config/conexao.php";

$id = $_SESSION["usuario_id"];

$sql = "SELECT * FROM usuarios WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<h2>Meu Perfil</h2>

<form id="form-perfil" action="atualizar_perfil.php" method="POST">

<input type="hidden" name="id" value="<?php echo $usuario["id"]; ?>">

<div class="mb-3">
<label>Nome</label>
<input type="text" name="nome" class="form-control" value="<?php echo $usuario["nome"]; ?>">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" class="form-control" value="<?php echo $usuario["email"]; ?>" disabled>
</div>

<button class="btn btn-primary">Atualizar Perfil</button>

</form>

<hr>

<a href="excluir_conta.php" class="btn btn-danger"
data-confirm="Tem certeza que deseja excluir sua conta?">

Excluir minha conta

</a>

</div>

<?php include "includes/footer.php"; ?>