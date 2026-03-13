<?php

$pagina = "usuarios";

require "config/verifica_login.php";
require "config/conexao.php";

if($_SESSION["usuario_tipo"] != "admin"){
header("Location: dashboard.php");
exit;
}

include "includes/header.php";
include "includes/menu.php";

?>

<div class="container mt-5">

<h2>Novo Usuário</h2>

<form id="form-usuario" action="salvar_usuario.php" method="POST">

<div class="mb-3">
<label>Nome</label>
<input type="text" name="nome" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Senha</label>
<input type="password" name="senha" class="form-control" required>
</div>

<div class="mb-3">

<label>Tipo</label>

<select name="tipo" class="form-control">

<option value="usuario">Usuário</option>
<option value="tecnico">Técnico</option>
<option value="admin">Administrador</option>

</select>

</div>

<button class="btn btn-success">Salvar</button>

<a href="usuarios.php" class="btn btn-secondary">Voltar</a>

</form>

</div>

<?php include "includes/footer.php"; ?>